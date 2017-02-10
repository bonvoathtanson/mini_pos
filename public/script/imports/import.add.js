(function() {
    $('#importdate').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: moment()
    });

    $('#transferdate').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: moment()
    });

    $('#importdate').on('dp.change', function (e) {
        $('#formImport').bootstrapValidator('revalidateField', 'ImportDate');
        //$('#askdate').data('DateTimePicker').maxDate(e.date);
    });

    SetValidation();

    $('body').on('change', '#itemid', function(){
        var id = $(this).val();
        var price = $(this).find('option:selected').attr('price');
        if(id == ''){
            $('#quantity').val('');
            $('#saleprice').val('0');
        }else{
            $('#saleprice').val(price);
            $('#quantity').focus();
        }
        $('#formImport').bootstrapValidator('revalidateField', 'SalePrice');
    });

    $('body').on('keypress', '#quantity', function(event){
        if(event.which == 13){
            event.preventDefault();
            CalTotal();
            $('#saleprice').focus();
        }
    });

    $('body').on('keypress', '#saleprice', function(event){
        if(event.which == 13){
            event.preventDefault();
            CalTotal();
            $('#carnumber').focus();
        }
    });

    $('body').on('keypress', '#carnumber', function(event){
        if(event.which == 13){
            event.preventDefault();
            $('#payamount').focus();
        }
    });

    $('body').on('focus blur', '#saleprice, #quantity', function(){
        CalTotal();
    });

    $('body').on('change', '#typeid', function(){
        var value = $(this).val();
        if(value == 0){
            $('#group-date').hide();
        }else{
            $('#group-date').show();
        }
    });

    function CalTotal(){
        var qty = $('#quantity').val();
        if(qty == null || qty == ''){
            qty = 0;
        }
        var price = $('#saleprice').val();
        if(price == null || price == ''){
            price = 0;
        }
        var total = qty * price;
        $('#totalamount').val(total);
    }

    function SaveOrUpdate()
    {
        $('body').append(Loading());
        var item = $('#formImport').serialize();
        if(parseInt($('#totalamount').val()) < parseInt($('#payamount').val())){
            swal('សូមពិនិត្យចំនួនប្រាក់ត្រូវបង់', '', 'warning');
            $('body').find('.loading').remove();
            return false;
        }
        $.ajax({
            type: 'POST',
            url: burl + '/insert/import',
            data: item
        }).done(function (data) {
            console.log(data);
            if (data.IsError == false) {
                window.location.href = burl + '/view/import';
            } else {
                swal(data.Message, '', 'success');
            }
        }).complete(function (data) {
            $('body').find('.loading').remove();
        });
    }

    function SetValidation()
    {
        var form = $('body').find('#formImport');
        form.bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                ItemId: {
                    validators: {
                        notEmpty: {
                            message: 'សូមជ្រើសមុខទំនិញ'
                        }
                    }
                },
                ImportDate:{
                    validators: {
                        notEmpty: {
                            message: 'សូមធ្វើការបញ្ចូលថ្ងៃខែឆ្នាំនាំចូល'
                        }
                    }
                },
                Quantity: {
                    validators: {
                        notEmpty: {
                            message: 'ចំនួន តំរូវអោយបញ្ចូល'
                        },
                        integer: {
                            message: 'ចំនួនអាចបញ្ចូលបានតែចំនួនគត់'
                        }
                    }
                },
                SalePrice: {
                    validators: {
                        notEmpty: {
                            message: 'សូមធ្វើកាបញ្ចូលតំលៃ'
                        },
                        numeric: {
                            message: 'តំលៃបញ្ចូលបានតែលេខ'
                        }
                    }
                },
                PayAmount: {
                    validators: {
                        notEmpty: {
                            message: 'សូមធ្វើកាបញ្ចូលតំលៃ'
                        },
                        numeric: {
                            message: 'តំលៃបញ្ចូលបានតែលេខ'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            SaveOrUpdate();
        });

        $('body').on('click', '#save', function (e) {
            e.preventDefault();
            form.bootstrapValidator('validate');
        });
    }
})();
