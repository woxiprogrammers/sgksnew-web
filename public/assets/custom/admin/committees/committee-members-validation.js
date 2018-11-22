/**
 * Created by vaibhav on 19/11/18.
 */
var  CreateMembers = function () {
    var handleCreate = function() {
        var form = $('#create-members');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                "en[full_name]": {
                    required: true
                },
                "en[designation]": {
                    required: true
                },
                "en[mobile_number]":{
                    required: true,
                    maxlength : 10
                }
            },
            messages: {
                "en[full_name]": {
                    required: "full name is required.",
                },
                "en[designation]": {
                    required: "Designation is required."
                },
                "en[mobile_number]": {
                    required: "mobile number required",
                    maxlength: "number should not be greater than 10"
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

