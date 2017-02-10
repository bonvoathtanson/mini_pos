(function(){

    ViewItem();

    function ViewItem(){
        GetItems(function(customers){
            RenderTable(customers, function(element, total, amount, remain){
                $('#importTable tbody').html(element);
                $('#totalamount').text(total);
                $('#payamount').text(amount);
                $('#remain').text(remain);
            });
        });
    }

    function GetItems(callback) {
        $('body').append(Loading());
        $.ajax({
            url: burl + '/find/import',
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

    function RenderTable(customers, callback){
        var element = '';
        if((customers != null) && (customers.length > 0)){
            var totalsale = 0;
            var totalpayment = 0;
            var totalremain = 0;
            $.each(customers, function(index, item){
                var rowcolor = '';
                var remain = (item.SubTotal-item.PayAmount);
                if(remain == 0){
                    rowcolor = 'success';
                }
                element += '<tr class="' + rowcolor + '" data-id="' + item.Id + '">' +
                                '<td><a href="'+ burl +'/detail/supplier/'+ item.SupplierId +'">' + item.supplier.SupplierName + '</a></td>' +
                                '<td>' + item.item.ItemName + '</td>' +
                                '<td class="center">' + moment(item.ImportDate).format('DD-MM-YYYY') + '</td>' +
                                '<td class="center">' + item.Quantity + '</td>' +
                                '<td class="center">' + item.SalePrice + '</td>' +
                                '<td class="center" style="text-align:right;">' + item.SubTotal + '</td>' +
                                '<td class="center" style="text-align:right;">' + item.PayAmount + '</td>' +
                                '<td class="center" style="text-align:right;">' + remain + '</td>' +
                                '<td class="center no-print">' +
                                    '<button type="button" class="btn btn-danger btn-e delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>' +
                                '</td>'
                            '</tr>';
                            totalsale += parseInt(item.SubTotal);
                            totalpayment += parseInt(item.PayAmount);
                            totalremain += remain;
            });
        }
        if(typeof callback == 'function'){
                callback(element,totalsale, totalpayment, totalremain);
        }
    }
    $('body').on('click','#btnPrint',function(){
        var displayTitle = 'តារាងការទិញចូល';
        var elem = $('.container-A4').html();
        var option = {};
        Print(displayTitle,option, elem);
    });
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
                url: burl + '/delete/import/' + id,
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
})();
