jQuery(function($) {
    var modules = $('.d-mod-djmitry-form');

    modules.each(function() {
        var module = $(this),
            url = module.find('form').attr('action');

        getToken(url, module);
        
        $('form', module).on('submit', function(e) {
            e.preventDefault();
            send(url, $(this));
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

    function send(form, url) {
        var fileInput = form.find(':file'),
            formData = new FormData(form.get(0)),
            data = form.serialize(),
            parent = form.closest('.d-mod-djmitry-form'),
            messageBlock = parent.find('.d-mod-djmitry-form__message');

        if (fileInput.length) {
            formData.append(fileInput.attr('name'), fileInput.get(0).files[0]);
        }

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
                messageBlock.text(data.message);
            },
            error: function(xhr, status) {
                console.log(xhr);
                messageBlock.addClass('d-message_error').text(xhr.responseText);
            },
            complete: function() {
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
        if (!$(e.target).closest('.d-mod-djmitry-form__inner').length) {
            $(this).removeClass('d-open');
        }
    });
});