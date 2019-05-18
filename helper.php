<?php

class ModDjmitryFormHelper
{
    private $params;
    private $app;
    private $session;

    public function __construct($params = null)
    {
        $this->app = JFactory::getApplication('site');
        $this->session = JFactory::getSession();
        $this->module_id = (int)$this->app->input->getInt('module_id',0);
        if (!$this->module_id) {
            throw new Exception('No module_id');
        }

        $this->token_name = 'djmitry_form_' . $this->module_id . '_token';

        if ($params) {
            $this->params = $params;
        } else {
            $module = JTable::getInstance('module');
            $module->load($this->module_id);
            if ((int) $module->id <= 0 || (int) $module->id != $this->module_id){
                throw new Exception(JText::_('MOD_SIMPLEFORM2_FORM_NOT_FOUND'));
            }
            $params = new JRegistry;
            $params->loadString($module->params);
            $this->params = $params;
        }
    }

    public function execute()
    {
        $validator = 'ModDjmitryFormValidator';

        if (!$this->validateToken()) {
            return ['status' => 0, 'message' => 'Ошибка валидации'];
        }
        
        $input = $this->app->input;
        $fields = $input->get('data', array(), 'ARRAY');
        
        if ($this->params->get('use_recaptcha') && !ReCaptcha::validate($this->params->get('recaptcha_secret_key'), $input->get('recaptcha'))) {
            return ['status' => 0, 'message' => 'Ошибка reCaptcha'];
        }
        
        $settings = $this->getSettings();
        if (!empty($settings['status']) && $settings['status'] === 0) {
            return $settings;
        }
        
        $validate = $validator::validate($fields, $settings, $input);
        if (is_array($validate) && $validate['status'] === 0) {
            return $validate;
        }

        $body = $this->createEmailBody($fields, $settings);
        $file = $input->files->get('data')['file'];
        $name = $fields['name'];
        return $this->sendMail($body, $file, $name);
    }


    public function getToken()
    {
        $value = substr(md5(uniqid('sjfhne', true)), 0, 10);
        $this->session->set($this->token_name, $value);
        echo json_encode(array('token' => $this->session->get($this->token_name)));
    }

    private function validateToken()
    {
        $token = $this->app->input->getString('_token');
        $save_token = $this->session->get($this->token_name);
        // FIXME: echo "$token $save_token";
        if (isset($token) /*&& $token === $save_token*/) {
            return true;
        }
        return false;
    }

    private function createEmailBody(Array $fields, $settings)
    {
        $body = "<table>";
        foreach ($settings as $setting) {
            $name = $setting['name'];

            if ($name === 'agree') {
                continue;
            }

            if (!empty($fields[$name])) {
                if (is_array($fields[$name])) {
                    $value = implode(', ', $fields[$name]);
                } else {
                    $value = $fields[$name];
                }

                $body .= "<tr><td>$setting[label]:</td><td>$value</td></tr>";
            }
        }
        $body .= "</table>";
        return $body;
    }

    private function sendMail($body, $file = null, $name) 
    {
        $mailer = JFactory::getMailer();
        $config = JFactory::getConfig();
        $recipient = explode(',', $this->params->get('email'));

        $sender = array($config->get('mailfrom'), $config->get('fromname'));
        $mailer->setSender($sender);
        $mailer->addRecipient($recipient);
        $mailer->setSubject($this->params->get('subject'));
        $mailer->isHTML(true);
        $mailer->setBody($body);
        if ($file) {
            $mailer->addAttachment($file['tmp_name'], $file['name']);
        }
    
        $send = $mailer->Send();
        if ($send !== true) {
            return ['status' => 0, 'message' => 'Ошибка отправки. ' . $send->get('message')];
        } else {
            $messasge = str_replace('{name}', $name, $this->params->get('message_send'));
            return ['status' => 1, 'message' => $messasge, 'metrika' => $this->params->get('yandex_metrika'), 'goal' => $this->params->get('yandex_goal')];
        }
    }

    private function getSettings()
    {
        $data = json_decode($this->params->get('fields_settings'), true);
        if (is_null($data)) {
            //throw new Exception('Неверный формат настроек полей.');
            return ['status' => 0, 'message' => 'Неверный формат настроек полей.'];
        }
        
        $settings = [];
        foreach ($data as $key => $item) {
            $settings[$item['name']] = $item;
        }
        
        if (!count($settings)) {
            //throw new Exception('Отсутствуют поля.');
            return ['status' => 0, 'message' => 'Отсутствуют поля.'];
        }
        
        return $settings;
    }
}