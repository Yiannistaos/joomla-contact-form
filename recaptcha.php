<?php


class ReCaptcha 
{
    public static function validate($secretKey, $captcha) 
    {
        if (!$captcha) {
            echo 'Отсутствует рекаптча';
            exit;
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = ['secret' => $secretKey, 'response' => $captcha];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $responseKeys = json_decode($response,true);

        if ($responseKeys["success"]) {
            return true;
        }
        return false;
    }
}