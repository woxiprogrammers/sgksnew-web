var  CreateMain = function () {
    var handleCreate = function() {
        var form = $('#create-main');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                client_name: {
                    required: true
                },
                project_name: {
                    required: true
                },
                site_name: {
                    required: true
                },
                main_category: {
                    required: true
                }
            },

            messages: {
                client_name: {
                    required: "Client name is required."
                },
                project_name: {
                    required: "Project name is required."
                },
                site_name: {
                    required: "Site name is required."
                },
                main_category: {
                    required: "Main category is required."
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
            handleCreate();
        }
    };
}();

var  EditMain = function () {
    var handleCreate = function() {
        var form = $('#edit-main');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                client_name: {
                    required: true
                },
                project_name: {
                    required: true
                },
                site_name: {
                    required: true
                },
                main_category: {
                    required: true
                }
            },

            messages: {
                client_name: {
                    required: "Client name is required."
                },
                project_name: {
                    required: "Project name is required."
                },
                site_name: {
                    required: "Site name is required."
                },
                main_category: {
                    required: "Main category is required."
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
            handleCreate();
        }
    };
}();

