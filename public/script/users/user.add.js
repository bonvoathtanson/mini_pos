(function(){
    $('.list-group-item:eq(10)').addClass('active');
    SetValidation();
    function SaveOrUpdate() {
        $('body').append(Loading());
        var item = $('#formUser').serialize();
        $.ajax({
            type: 'POST',
            url: burl + '/insert/user',
            data: item
        }).done(function (data) {
            if (data.IsError == false) {
                window.location.href = burl + '/view/user';
            } else {
                swal(data.Message, '', 'warning');
            }
        }).complete(function (data) {
            $('body').find('.loading').remove();
        });
    }
    function SetValidation() {
        var form = $('body').find('#formUser');
        form.bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                Name: {
                    validators: {
                        notEmpty: {
                            message: "ឈ្មោះគណនេយ្យតំរូវអោយធ្វើការបញ្ចូល"
                        },
                        stringLength: {
                            min: 5,
                            max: 32,
                            message: "ឈ្មោះគណនេយ្យ ចន្លោះពី 5 ដល់ 32 តួអក្សរ"
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\-_@]+$/,
                            message: "លេខសំងាត់អនុញ្ញាតិតែ [a-z]-[A-Z]-[_ @] ប៉ុន្នោះ"
                        }
                    }
                },
                Email: {
                    validators: {
                        notEmpty: {
                            message: 'សូមបញ្ចូល អ៊ីម៉ែល'
                        },
                        emailAddress: {
                            message: 'សូមធ្វើការពិនិត្យទំរង់របស់អ៊ីម៉ែលម្តងទៀត'
                        }
                    }
                },
                Password: {
                    validators: {
                        notEmpty: {
                            message: "លេខសំងាត់តំរូវអោយបញ្ចូល"
                        },
                        stringLength: {
                            min: 6,
                            max: 32,
                            message: "លេខសំងាត់នៅចន្លោះពី 6 ដល់ 32"
                        },
                        different: {
                            field: "Name",
                            message: "លេខសំងាត់មិនតំរូវអោយដូចឈ្មោះគណនេយ្យ"
                        }
                    }
                },
                Verify: {
                    validators: {
                        notEmpty: {
                            message: "ការបញ្ជាក់លេខសំងាត់តំរូវអោយបញ្ចូល"
                        },
                        identical: {
                            field: "Password",
                            message: "ការបញ្ជាក់លេខសំងាត់មិនត្រឹងត្រូវ"
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            SaveOrUpdate();
        });

        $('body').on('click', '#submit', function (e) {
            form.bootstrapValidator('validate');
        });
    }
})();
