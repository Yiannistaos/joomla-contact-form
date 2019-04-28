jQuery(function($) {
    let settings = $('#jform_params_fields_settings'),
        templateField = $('<div class="d-field row-fluid">\
            <div class="control-group">\
                <div class="span3"><input type="text" name="name" placeholder="name"></div>\
                <div class="span3"><input type="text" name="label" placeholder="label"></div>\
                <div class="span3">\
                    <select name="type" placeholder="label">\
                        <option value="text">Текст</option>\
                        <option value="file">Файл</option>\
                        <option value="agree">Соглашение</option>\
                    </select>\
                </div>\
                <div class="span3"><div class="control-label"><label>Обязательно<input type="checkbox" name="require" value="1"></label></div></div>\
            </div>\
        </div>')

    function init() {
        let value = settings.val(),
            data = JSON.parse(value),
            fields = $('<div class="d-fields">');

        settings.after(fields);
        settings.after('<div class="control-group">');

        $.each(data, function(i, elem) {
            let newField = templateField.clone();
            newField.find('[name=name]').val(elem.name);
            newField.find('[name=label]').val(elem.label);
            newField.find('[name=type]').val(elem.type);//.trigger("chosen:updated");
            newField.find('[name=required]').val(elem.required);
            fields.append(newField);
            console.log(elem);
        });
        
        fields.after('<button type="button" class="d-field__add btn btn-small btn-success">Добавить</button>')
    };

    init();
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