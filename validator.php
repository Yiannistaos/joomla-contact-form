<?php

class ModDjmitryFormValidator
{
    const MAX_FILE_SIZE = 1;

    public static function validate(Array $fields, Array $settings, $input)
    {        
        //$diff = array_diff_key($settings, $fields);

        foreach ($fields as $key => $value) {
            if (!isset($settings[$key])) {
                return ['status' => 0, 'message' => 'Не полные настройки формы.'];
            }

            if ($settings[$key]['required']) {
                if (!self::fill($value)) {
                    return ['status' => 0, 'message' => 'Заполните обязательные поля.'];
                }
            }

            $result = self::checkType($value, $settings[$key]['type']);
            if (is_array($result) && $result['status'] === 0) {
                return $result;
            }
        }

        if ($settings['file']) {
            $file = $input->files->get('data')['file'];
            //print_r($file); exit;
            if ($settings['file']['required'] && $file['error'] !== 0) {
                return ['status' => 0, 'message' => 'Файл отсутствует'];
            }

            $result = self::checkFile($file);
            if ($result['status'] === 0) {
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

    public static function fill($value)
    {
        if (!trim($value)) {
            return false;
        }
        return true;
    }
    
    private static function checkFile($file)
    {
        if (!$file) {
            return ['status' => 0, 'message' => 'Нет файла'];
        }

        $size = $file['size'] / 1024 / 1024;
        if ($size > self::MAX_FILE_SIZE) {
            return ['status' => 0, 'message' => 'Размер файла ' . $size . 'мб, не должен быть больше ' . self::MAX_FILE_SIZE . 'мб'];
        }
    }

    private static function fillFile($file)
    {
        return is_file($file);
    }
}