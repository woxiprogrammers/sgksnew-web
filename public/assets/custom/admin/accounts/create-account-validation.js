/**
 * Created by vaibhav on 13/11/18.
 */

var  CreateAccount = function () {
    var handleCreate = function() {
        var form = $('#create-accounts');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                "en[account_name]": {
                    required: true
                },
                "en[description]": {
                    required: true
                },
                "en[city]":{
                    required : true
                }
            },
            messages: {
                "en[account_name]": {
                    required: "Account name is required."
                },
                "en[description]": {
                    required: "Description is required."
                },
                "en[city]":{
                    required : "please select the city"
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                success.hide();
                error.show();
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label
                    .closest('.form-group').addClass('has-success');
            },
            submitHandler: function (form) {
                $("button[type='submit']").prop('disabled', true);
                success.show();
                error.hide();
                form.submit();
            }
        });
    }
    return {
        init: function () {
            handleCreate();
        }
    };
}();

