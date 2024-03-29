jQuery(function($) {
    let settings = $('#jform_params_fields_settings'),
        templateField = $('<div class="d-field row-fluid">\
            <div class="control-group">\
                <div class="span3"><input type="text" name="name" placeholder="name"></div>\
                <div class="span3"><input type="text" name="label" placeholder="label"></div>\
                <div class="span3">\
                    <select name="type" placeholder="label">\
                        <option value="text">Текст</option>\
                        <option value="email">Email</option>\
                        <option value="phone">Телефон</option>\
                        <option value="file">Файл</option>\
                        <option value="agree">Соглашение</option>\
                    </select>\
                </div>\
                <div class="span2"><div class="control-label"><label>Обязательно<input type="checkbox" name="required" value="1"></label></div></div>\
                <div class="span1"><button type="button" class="d-field__remove btn btn-small btn-danger">Удалить</button></div>\
            </div>\
        </div>'),
        fields = $('<div class="d-fields">');

    init();

    function init() {
        let value = settings.val(),
            data = JSON.parse(value);

        settings.after(fields);
        settings.after('<div class="control-group">');

        $.each(data, function(i, elem) {
            let newField = templateField.clone();
            newField.find('[name=name]').val(elem.name);
            newField.find('[name=label]').val(elem.label);
            newField.find('[name=type]').val(elem.type);
            newField.find('[name=required]').prop('checked', elem.required);
            fields.append(newField);
            console.log(elem);
        });
        
        fields.after('<button type="button" class="d-field__add btn btn-small btn-success">Добавить</button>')
    };

    // Добавить поле
    $('.d-field__add').click(function(e) {
        e.preventDefault();
        let newField = templateField.clone();
        fields.append(newField);
        changeSettings();
    });

    // Удалить поле
    fields.on('click', '.d-field__remove', function(e) {
        e.preventDefault();
        $(this).closest('.d-field').remove();
        changeSettings();
    });

    // Обновить поле
    fields.on('change', function() {
        changeSettings();
    });

    // Обновить настройки
    function changeSettings() {
        let data = [];
        fields.find('.d-field').each(function(elem) {
            let row = {};
            row.name = $(this).find('[name=name]').val();
            row.label = $(this).find('[name=label]').val();
            row.type = $(this).find('[name=type]').val();
            row.required = $(this).find('[name=required]').is(':checked');
            data.push(row);
        });
        settings.val(JSON.stringify(data));
    };
}); 
/*
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
*/