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
            return ['status' => 0, 'message' => 'Ошибка'];
        }
        
        $input = $this->app->input;
        $fields = $input->get('data', array(), 'ARRAY');
        $settings = $this->getSettings();
        
        $result = $validator::validate($fields, $settings);
        if (is_array($result) && !$result['status']) {
            return $result;
        }
        
        $file = $input->files->get('file');

        if ($file['size'] / 1024 / 1024 > 2) {
            return ['status' => 0, 'message' => 'Размер файла не должен быть больше 2мб'];
        }

        $body = $this->createEmailBody($fields, $settings);
        return $this->sendMail($body, $file);
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
        if (isset($token) && $token === $save_token) {
            return true;
        }
        return false;
    }

    private function createEmailBody(Array $fields, $settings)
    {
        $body = "<table>";
        foreach ($settings as $setting) {
            $name = $setting['name'];
            if (!empty($fields[$name])) {
                $body .= "<tr><td>$setting[label]:</td><td>$fields[$name]</td></tr>";
            }
        }
        $body .= "</table>";
        return $body;
    }

    private function sendMail($body, $file = null) 
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
            return ['status' => 1, 'message' => 'Письмо успешно отправлено.', 'metrika' => $this->params->get('yandex_metrika'), 'goal' => $this->params->get('yandex_goal')];
        }
    }

    private function getSettings()
    {
        $data = json_decode($this->params->get('fields_settings'), true);
        if (is_null($data)) {
            throw new Exception('Неверный формат настроек полей.');
        }

        $settings = [];
        foreach ($data as $key => $item) {
            $settings[$item['name']] = $item;
        }

        return $settings;
    }
}