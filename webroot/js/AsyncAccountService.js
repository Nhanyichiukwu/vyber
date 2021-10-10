
AsyncAccountService = {
    config: {},
    USERNAME_PATTERN: /^[A-Za-z][A-Za-z0-9]*(?:__[A-Za-z0-9]+)*(?:_[A-Za-z0-9]+)*$/i,
    init: function (config)
    {
        if (typeof config === 'undefined') {
            throw new Error('AssyncAccountService.init() requires one parameter');
        }

        this.config = $.parseJSON(config);
    },
    getRequestHandler: function ()
    {
        if (this.config.hasOwnProperty('asxhrh'))
            return this.config.asxhrh + '/';
        return null;
    },
    validateUsername: function (i)
    {
        if ($(i).val().length === 0) {
            $(i).removeClass('is-valid').addClass('is-invalid');
            $('.input-feedback').removeClass('valid-feedback')
                .addClass('invalid-feedback').html('Please input username!');
            return false;
        } else if ($(i).val().length < 3) {
            $(i).removeClass('is-valid').addClass('is-invalid');
            $('.input-feedback').removeClass('valid-feedback')
                .addClass('invalid-feedback')
                .html('Username too short!');
            return false;
        } else if ($(i).val().length > 15) {
            $(i).removeClass('is-valid').addClass('is-invalid');
            $('.input-feedback').removeClass('valid-feedback')
                .addClass('invalid-feedback')
                .html('Username too long! 15 Characters allowed.');
            return false;
        } else if (!this.USERNAME_PATTERN.test($(i).val())) {
            $(i).removeClass('is-valid')
                .addClass('is-invalid');
            $('.input-feedback')
                .removeClass('valid-feedback')
                .addClass('invalid-feedback')
                .html('Invalid character or username format.');
            return false;
        } else if (this.isInUse('e_users','username', $(i).val())) {
            $(i).removeClass('is-valid')
                .addClass('is-invalid');
            $('.input-feedback')
                .removeClass('valid-feedback')
                .addClass('invalid-feedback')
                .html('Username already taken.');
            return false;
        } else {
            $(i).removeClass('is-invalid')
                .addClass('is-valid');
            $('.input-feedback')
                .removeClass('invalid-feedback')
                .addClass('valid-feedback')
                .html('Available.');
        }
    },

    isInUse: function(t, f, d)
    {
        var url = this.getRequestHandler() + 'lookup/';
        var tokenizer = $('form.ajax-tokenizer');
        var data = tokenizer.serialize();
        data += '&t=' + t + '&f=' + f + '&d=' + d;

        var jqXHR = $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json'
        });
        if (jqXHR['status'] === '200') {
            if (jqXHR.responseText === 'exists')
                return true;
            else if (jqXHR['responseText'] === 'not_exists')
                return false;
        }
//        console.log(jqXHR.valueOf());
    },

    sendRequest: function (type, url, callback)
    {
        $.ajax({
            type: type,
            url: url,
            beforeSend: function(xhr)
            {
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            },
            success: function ()
            {
                callback();
            },
            error: function ()
            {

            }
        })
    },
    checkSession: function()
    {
        var url = this.getRequestHandler() + 'check-session/',
            lastActiveAccount = this.config.account;
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (account) {
                if (typeof account.username === 'undefined') {
                    $('#re-auth-modal').modal('show');
                } else if (account.username !== lastActiveAccount.username) {
                    location.reload();
                }
            }
        });
    }

};


