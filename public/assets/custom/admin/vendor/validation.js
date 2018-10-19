var  CreateVendor = function () {
    var handleCreate = function() {
        var form = $('#create-vendor');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                name: {
                    required: true
                },
                company:{
                    required: true
                },
                mobile:{
                    required: true
                },
                email:{
                    required: true,
                    email: true
                },
                gstin:{
                    required: true
                },
                city:{
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Vendor Name is required."
                },
                company:{
                    required: "Company Name is required."
                },
                mobile:{
                    required: "Mobile is required."
                },
                email:{
                    required: "Email is required."
                },
                gstin:{
                    required: "GSTIN is required."
                },
                city:{
                    required: "City is required."
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
                if($(".cities:checkbox:checked").length > 0) {
                    $("button[type='submit']").prop('disabled', true);
                    success.show();
                    error.hide();
                    form.submit();
                }else{
                    alert('Please select atleast one city');
                }
            }
        });
    }
    return {
        init: function () {
            handleCreate();
        }
    };
}();

var  EditVendor = function () {
    var handleEdit = function() {
        var form = $('#edit-vendor');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                name: {
                    required: true
                },
                company:{
                    required: true
                },
                mobile:{
                    required: true
                },
                email:{
                    required: true,
                    email: true
                },
                gstin:{
                    required: true
                },
                city:{
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Vendor Name is required."
                },
                company:{
                    required: "Company Name is required."
                },
                mobile:{
                    required: "Mobile is required."
                },
                email:{
                    required: "Email is required."
                },
                gstin:{
                    required: "GSTIN is required."
                },
                city:{
                    required: "City is required."
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
    };
    return {
        init: function () {
            handleEdit();
        }
    }
}();




$(document).ready(function() {
});

