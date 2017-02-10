(function(){
    $(':radio').iCheck({
        radioClass: 'iradio_minimal'
    });
    SetValidation();
    function SaveOrUpdate() {
        $('body').append(Loading());
        var item = $('#formSupplier').serialize();
        $.ajax({
            type: 'POST',
            url: burl + '/update/supplier',
            data: item
        }).done(function (data) {
            if (data.IsError == false) {
                window.location.href = burl + '/view/supplier';
            } else {
                swal(data.Message, '', 'success');
            }
        }).complete(function (data) {
            $('body').find('.loading').remove();
        });
    }
    function SetValidation() {
        var form = $('body').find('#formSupplier');
        form.bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                SupplierCode: {
                    validators: {
                        notEmpty: {
                            message: 'លេខកូដ​ តំរូវអោយបញ្ចូល'
                        }
                    }
                },
                SupplierName: {
                    validators: {
                        notEmpty: {
                            message: 'ឈ្មោះអតិថិជន់ តំរូវអោយបញ្ចូល'
                        }
                    }
                },
                PhoneNumber: {
                    validators: {
                        notEmpty: {
                            message: 'លេខទូរស័ព្ធ តំរូវអោយបញ្ចូល'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            SaveOrUpdate();
        });
    }

})();
