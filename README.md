
## Laravel Form Generator
[![Latest Version on Packagist](https://img.shields.io/packagist/v/djmitry/joomla-contact-form.svg)](https://packagist.org/packages/djmitry/joomla-contact-form)
[![Software License](https://img.shields.io/packagist/l/djmitry/joomla-contact-form.svg)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/djmitry/joomla-contact-form.svg)](https://packagist.org/packages/djmitry/joomla-contact-form)

# Особенности
1. Возможность использовать Google reCaptcha 3.0
    1. Добавить свой сайт в https://www.google.com/recaptcha/admin/create выбрав reCAPTCHA v3
    2. Скопировать ключи и добавить в модуль на вкладке "Капча"
1. Имеется настройка для учета целей яндекс метрики
2. Обычная или всплывающая форма
3. Отключение стилей

# Установка
Скачать архив и установить через расширения Joomla

# Использование
В модулях появится Djmitry Form

# Пример полей
```bash
[
    {
        "name": "name",
        "label": "Имя",
        "type": "text",
        "required": 1
    },
    {
        "name": "email",
        "label": "E-mail",
        "type": "text",
        "required": 1
    },
    {
        "name": "phone",
        "label": "Телефон",
        "type": "text",
        "required": 1
    },
    {
        "name": "file",
        "label": "Файл",
        "type": "file",
        "required": 1
    },
    {
        "name": "message",
        "label": "Сообщение",
        "type": "text",
        "required": 1
    },
    {
        "name": "agree",
        "label": "Соглашение",
        "type": "agree",
        "required": 1
    }
]
```

# Примеры
Обычная
![Alt text](/screenshots/2019-04-27_15-23-27.png?raw=true "Обычная")

Всплывающая
![Alt text](/screenshots/2019-04-27_15-23-56.png?raw=true "Всплывающая")