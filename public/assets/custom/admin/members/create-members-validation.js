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
                "en[first_name]": {
                    required: true
                },
                "en[middle_name]": {
                    required: true
                },
                "en[last_name]": {
                    required: true
                },
                "en[mobile_number]":{
                    required: true,
                    maxlength : 10
                },
                "en[city]":{
                    required : true
                },
                "en[address]":{
                    required : true
                }
            },
            messages: {
                "en[first_name]": {
                    required: "first name is required.",
                },
                "en[middle_name]": {
                    required: "middle name is required."
                },
                "en[last_name]": {
                    required: "last name is required."
                },
                "en[mobile_number]": {
                    required: "mobile number required",
                    maxlength: "Please enter valid mobile number "
                },
                "en[country]":{
                    required : "please select the country"
                },
                "en[state]":{
                    required : "please select the state"
                },
                "en[city]":{
                    required : "please select the city"
                },
                "en[address]": {
                    required : "please enter the address"
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

