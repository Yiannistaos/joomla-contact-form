jQuery(function($) {
    var modules = $('.d-mod-djmitry-form');

    modules.each(function() {
        var module = $(this),
            url = module.find('form').attr('action');

        getToken(url, module);
        
        $('form', module).on('submit', function(e) {
            e.preventDefault();
            let form = $(this),
                recaptchaKey = module.data('recaptcha-key');

            if (recaptchaKey) {
                form.find('.d-submit').prop('disabled', true);
                grecaptcha.ready(function() {
                    grecaptcha.execute(recaptchaKey, {action: 'send_form'}).then(function(token) {
                        form.find('[name=recaptcha]').remove();
                        form.prepend('<input type="hidden" name="recaptcha" value="' + token + '">');
                        send(url, form);
                    });
                });
            } else {
                send(url, form);
            }
        });
    });

    function getToken(url, module) {
        setTimeout(function() { 
            $.ajax({
                url: url,
                type: 'post',
                data: {'task': 'getToken', 'module_id': module.data('id')},
                dataType: 'json',
                success: function(data, status, xhr) {
                    if (data.token) {
                        module.find('form').append('<input type="hidden" name="_token" value="'+ data.token +'">');
                    } else {
                        throw "No token";
                    }
                }, 
                error: function(xhr, status) {
                    console.log(xhr);
                },
            });
        }, 300);
    };

    function send(url, form) {
        let btnSubmit = form.find('.d-submit'),
            fileInput = form.find(':file'),
            formData = new FormData(form.get(0)),
            parent = form.closest('.d-mod-djmitry-form'),
            messageBlock = parent.find('.d-mod-djmitry-form__message');

        if (fileInput.length) {
            formData.append(fileInput.attr('name'), fileInput.get(0).files[0]);
        }

        btnSubmit.prop('disabled', true);

        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data, status, xhr) {
                console.log(data);
                
                if (data.status) {
                    $('.d-form, .d-text', parent).hide();
                    messageBlock.removeClass('d-message_error');
                    if (data.metrika && data.goal) {
                        ym(data.metrika, 'reachGoal', data.goal);
                    }
                } else {
                    messageBlock.addClass('d-message_error');
                }
                messageBlock.html(data.message);
            },
            error: function(xhr, status) {
                console.log(xhr);
                messageBlock.addClass('d-message_error').text(xhr.responseText);
            },
            complete: function() {
                btnSubmit.prop('disabled', false);
                messageBlock.show();
            },
        });
    };

    // Показать
    $('.d-show-djmitry-form').click(function(e) {
        e.preventDefault();
        let id = $(this).data('target'),
            target = $('.d-mod-djmitry-form.d-modal[data-id=' + id + ']');
        target.addClass('d-open');
    });

    // Скрыть
    $('.d-mod-djmitry-form').click(function(e) {
        if (!$(e.target).closest('.d-mod-djmitry-form__form').length) {
            $(this).removeClass('d-open');
        }
    });

    $('.d-mod-djmitry-form__close').click(function(e) {
        $(this).closest('.d-mod-djmitry-form').removeClass('d-open');
    });
});