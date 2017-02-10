(function(){
    $('.list-group-item:eq(9)').addClass('active');
    ViewItem();

    function ViewItem(){
        GetItems(function(data){
            var stock = (data.stock != null ? data.stock.Value : '0');
            $('[name="stock"]').val(stock);
            RenderTable(data.items, stock, function(element){
                $('#itemTable tbody').html(element);
            });
        });
    }

    function GetItems(callback) {
        $('body').append(Loading());
        $.ajax({
            url: burl + '/find/item',
            type: 'GET',
            dataType: 'JSON',
            contentType: 'application/json; charset=utf-8',
        }).done(function (data) {
            if(data.IsError == false){
                if(typeof callback == 'function'){
                    callback(data.Data);
                }
            }
        }).complete(function (data) {
            $('body').find('.loading').remove();
        });
    }

    function RenderTable(items, alertstock, callback){
        var element = '';
        if((items != null) && (items.length > 0)){
            $.each(items, function(index, item){
                var color = (alertstock >= item.UnitInStock ? 'info' : '');
                element += '<tr data-id="' + item.Id + '" class="' + color + '">' +
                '<td>' + item.ItemCode + '</td>' +
                '<td>' + item.ItemName + '</td>' +
                '<td class="center">' + item.SalePrice + '</td>' +
                '<td class="center">' + item.UnitInStock + '</td>' +
                '<td class="center">' +
                '<a href="' + burl + '/edit/item/' + item.Id + '" class="btn btn-success btn-e"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ' +
                '<button type="button" class="btn btn-danger btn-e delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>' +
                '</td>'
                '</tr>';
            });
        }
        if(typeof callback == 'function'){
            callback(element);
        }
    }

    $('body').on('click', '.delete', function () {
        var select = $(this).closest('tr');
        var id = $(select).attr('data-id');
        swal({
            title: 'លុប',
            text: 'តើអ្នកចង់លុបទិន្នន័យឬ ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'យល់ព្រម',
            cancelButtonText: 'បោះបង់',
            closeOnConfirm: false
        }, function () {
            $('body').append(Loading());
            $.ajax({
                type: 'GET',
                url: burl+'/delete/item/'+id,
                dataType: "JSON",
                contentType: 'application/json; charset=utf-8',
            }).done(function (data) {
                if (data.IsError == false) {
                    swal('ទិន្នន័យត្រូវបានលុបជោគជ័យ', '', 'success');
                    $(select).remove();
                } else {
                    swal(data.Message, '', 'success');
                }
            }).complete(function (data) {
                $('body').find('.loading').remove();
            });
        });
    });

    $('body').on('click', '#btnsetstock', function(){
        $('#stockmodal').modal({
            backdrop:'static'
        });
    });

    SetValidation();

    function SaveOrUpdate() {
        $('body').append(Loading());
        var item = $('#formStock').serialize();
        $.ajax({
            type: 'POST',
            url: burl + '/update/stock',
            data: item
        }).done(function (data) {
            console.log(data);
            if (data.IsError == false) {
                ViewItem();
                $('#stockmodal').modal('hide');
            } else {
                swal(data.Message, '', 'success');
            }
        }).complete(function (data) {
            $('body').find('.loading').remove();
        });
    }

    function SetValidation() {
        var form = $('body').find('#formStock');
        form.bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                stock: {
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
