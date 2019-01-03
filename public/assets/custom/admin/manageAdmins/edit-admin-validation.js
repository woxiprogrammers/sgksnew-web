/**
 * Created by vaibhav on 2/1/19.
 */

var  EditAdmin = function () {
    var handleCreate = function() {
        var form = $('#edit-admin');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                "fname": {
                    required: true
                },
                "lname": {
                    required: true
                },
                "email": {
                    required: true
                },
                "password":{
                    required : true
                },
                "user-role":{
                    required : true
                },
            },
            messages: {
                "fname": {
                    required: "first name is required.",
                },
                "lname": {
                    required: "last name is required."
                },
                "email": {
                    required: "email id is required."
                },
                "password":{
                    required : "please enter password"
                },
                "user-role":{
                    required : "please select user role"
                },

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

