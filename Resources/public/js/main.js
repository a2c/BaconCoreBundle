jQuery(document).ready(function($) {
    
    $('.icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue'
    });

    $('select.select2').select2({
        width : '100%'
    });

    $('select.select2').on('change', function () {
        $(this).valid();
    });

    $('#checkbox-select-all').on('ifChecked', function(event){
        $('.checkbox-select').iCheck('check');
    });

    $('#checkbox-select-all').on('ifUnchecked', function(event){
        $('.checkbox-select').iCheck('uncheck');
    });

    $('.checkbox-select').on('ifUnchecked', function(event){
        $('#checkbox-select-all').iCheck('indeterminate');
    });
    
    var saidOk = false;

    $('#batch-list').on('submit', function(event){
        if($('#batch-actions').val() == 'deleteBatch' && $(".checkbox-select:checked").length > 0) {
            if(saidOk) {
                $('input[name=_method]').val('POST');
            } else {
                $('#modalDeleteBatch').modal({
                    'show': true
                });

                return false;
            }
            
        } else {
            $('input[name=_method]').val('POST');
        }
    });

    $('#modalDeleteBatch').find('button[type=submit]').on('click', function(){
        saidOk = true;
        $('#batch-list').closest('form').submit();
    });

    $.validator.setDefaults({
        errorElement: "span",
        errorClass: "help-block",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass); //.removeClass(errorClass);
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass); //.addClass(validClass);
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.insertAfter(element.parent());
            } else if (element.hasClass('select2')) {
                error.insertAfter(element.next('span'));
            } else {
                error.insertAfter(element);
            }
        }
    });

    $('.content-wrapper form').each(function(){
        $(this).validate({
            lang: 'pt',
            rules: {
                'fos_user_registration_form[plainPassword][second]': {
                    equalTo: "#fos_user_registration_form_plainPassword_first"
                }
            }
        });
    });

});
