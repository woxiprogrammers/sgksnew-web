var  UnitsCreate = function () {
  var handleCreate = function() {
        var form = $('#create-unit');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                name: {
                    required: true,
                    remote: {
                        url: "/units/check-name",
                        type: "POST",
                        data: {
                            _token: function(){
                                return $("input[name='_token']").val();
                            },
                            name: function() {
                                return $( "#name" ).val();
                            }
                        }
                    }
                }
            },
            messages: {
                name: {
                    required: "Name is required.",
                    remote: "Unit already exists."
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

var  UnitsEdit = function () {
    var handleEdit = function() {
        var form = $('#edit-unit');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                name: {
                    required: true,
                    remote: {
                        url: "/units/check-name",
                        type: "POST",
                        data: {
                            unit_id: function(){
                                return $("#unit_id").val();
                            },
                            _token: function(){
                                return $("input[name='_token']").val();
                            },
                            name: function() {
                                return $( "#name" ).val();
                            }
                        }
                    }
                }
            },
            messages: {
                name: {
                    required: "Name is required.",
                    remote: "Unit already exists."
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
            handleEdit();
        }
    };
}();

var  UnitsConversionCreate = function () {
  var handleConversion = function() {
        var form = $('#create-conversion');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                from_unit: {
                    required: true
                },
                to_unit: {
                  required: true
                },
                from_value:{
                  required: true
                },
                to_value: {
                  required: true
                }
            },
            messages: {
                from_unit: {
                    required: "Unit is required."
                },
                to_unit: {
                  required: "Unit is required."
                },
                from_value:{
                  required: "Value is required."
                },
                to_value: {
                  required: "Value is required."
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
                success.show();
                error.hide();
                form.submit();
            }
        });
    }
    return {
        init: function () {
            handleConversion();
        }
    };
}();

var  UnitsConversionEdit = function () {
    var handleConversion = function() {
        var form = $('#edit-conversion');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                from_unit: {
                    required: true
                },
                to_unit: {
                    required: true
                },
                from_value:{
                    required: true
                },
                to_value: {
                    required: true
                }
            },
            messages: {
                from_unit: {
                    required: "Unit is required."
                },
                to_unit: {
                    required: "Unit is required."
                },
                from_value:{
                    required: "Value is required."
                },
                to_value: {
                    required: "Value is required."
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
                success.show();
                error.hide();
                form.submit();
            }
        });
    }
    return {
        init: function () {
            handleConversion();
        }
    };
}();
