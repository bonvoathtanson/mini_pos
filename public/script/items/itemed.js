(function(){
    $('.list-group-item:eq(9)').addClass('active');
    SetValidation();
    function SaveOrUpdate() {
        $('body').append(Loading());
        var item = $('#formItem').serialize();
        $.ajax({
            type: 'POST',
            url: burl + '/insert/item',
            data: item
        }).done(function (data) {
            if (data.IsError == false) {
                window.location.href = burl + '/view/item';
            } else {
                swal(data.Message, '', 'success');
            }
        }).complete(function (data) {
            $('body').find('.loading').remove();
        });
    }
    function SetValidation() {
        var form = $('body').find('#formItem');
        form.bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                itemcode: {
                    validators: {
                        notEmpty: {
                            message: 'សូមបញ្ចូល លេខកូដទំនិញ'
                        }
                    }
                },
                itemname: {
                    validators: {
                        notEmpty: {
                            message: 'សូមបញ្ចូល ឈ្មោះទំនិញ'
                        }
                    }
                },
                price: {
                    validators: {
                        notEmpty: {
                            message: 'សូមបញ្ចូល តំលៃលក់ចេញ'
                        },
                        numeric: {
                            message: 'តំលៃបញ្ចូលបានតែលេខ'
                        }
                    }
                },
                quantity: {
                    validators: {
                        notEmpty: {
                            message: 'សូមបញ្ចូល ចំនួនក្នុងស្តុក'
                        },
                        integer: {
                            message: 'ចំនួនអាចបញ្ចូលបានតែចំនួនគត់'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            SaveOrUpdate();
        });
        $('body').on('click', '#save', function (e) {
            form.bootstrapValidator('validate');
        });
    }
})();
