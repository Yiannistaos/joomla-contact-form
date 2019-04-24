<?php

class ModDjmitryFormValidator
{
    public static function validate(Array $fields, $settings)
    {        
        $num = 0;
        foreach ($fields as $key => $value) {
            $num++;

            if (!isset($settings[$key])) {
                throw new Exception('Не полные настройки формы');
            }

            if ($settings[$key]['required']) {
                if (!self::require($value)) {
                    return ['status' => 0, 'message' => 'Заполните обязательные поля.'];
                }
            }

            $result = self::checkType($value, $settings[$key]['type']);
            if (is_array($result) && !$result['status']) {
                return $result;
            }
        }
    }

    private static function checkType($value, $type)
    {        
        switch($type) {
            case 'phone': 
                if (!self::phone($value)) {
                    return ['status' => 0, 'message' => 'Введите правильный номер телефона.'];
                }
                break;
            case 'email': 
                if (!self::email($value)) {
                    return ['status' => 0, 'message' => 'Введите правильный e-mail'];
                }
                break;
        }
    }

    public static function email($value)
    {        
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public static function phone($value)
    {        
        if (preg_match('/^\+?[0-9]+[0-9\-\(\) ]+$/', $value)) {
            return true;
        }
        return false;
    }

    public static function require($value)
    {
        if (!trim($value)) {
            return false;
        }
        return true;
    }
}