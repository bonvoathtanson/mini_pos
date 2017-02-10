(function(){

    $('.list-group-item:eq(3)').addClass('active');

    var dateFrom = moment().format('YYYY-MM-1');
    var dateTo   = moment().format('YYYY-MM-DD');

    $('#saleFromDate').val(dateFrom);
    $('#saleToDate').val(dateTo);

    $('#saleFromDate').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: moment()
    });

    $('#saleToDate').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: moment()
    });

    $("#saleFromDate").on("dp.change", function (e) {
        $('#saleToDate').data("DateTimePicker").minDate(e.date);
    });
    $("#saleToDate").on("dp.change", function (e) {
        $('#saleFromDate').data("DateTimePicker").maxDate(e.date);
    });

    ViewItem();

    function ViewItem(){
        GetItems(function(customers){
            RenderTable(customers, function(element, total, amount, remain){
                if(element != '' && element != null)
                {
                    $('.box-null').hide();
                }else{
                    total ='';
                    amount='';
                    remain='';
                    $('.box-null').show();
                }
                $('#saleTable tbody').html(element);
                $('#totalamount').text(total + '0.00');
                $('#payamount').text(amount + '0.00');
                $('#remain').text(remain + '0.00');
            });
        });

    }
    //Function On selected customer name
    $('body').on('click','.selected',function(){
        var customerName = $(this).attr('data-name');
        var customerId   = $(this).attr('data-id');
        var carNumber   = $('#hdfcarNumber').val();
        $('#customerName').val(customerName);
        $('#hdfcustomerId').val(customerId);
        ViewItem();
        $('#myModal').modal('hide');
    });
    //Function on change car number
    $('body').on('change','#carNumber',function(){
        var carNumber = $(this).find(':selected').attr('name')
        var customerId = $('#hdfcustomerId').val();
        $('#hdfcarNumber').val(carNumber);
        ViewItem();
        $('#myModal').modal('hide');
    });
    //Function click on button search
    $('body').on('click', '#btnsearch', function () {
        var customerId   = $('#hdfcustomerId').val();
        var saleFormDate = $('#saleFromDate').val();
        var saleToDate   = $('#saleToDate').val();
        var CarNumber    = $('#CarNumber').val();
        if( customerId !='' || saleFormDate != '' || saleToDate != '' || CarNumber !='' ){
            ViewItem();
        }else{
            $('.box-null').show();
            $('#saleTable tbody tr').remove();
        }
    });

    //Function click on button reset
    $('body').on('click', '#btnClear', function () {
        $('#hdfcustomerId').val('');
        $('#customerName').val('');
        ViewItem();
    });

    //+ $('#saleFormDate').val() + $('#saleToDate').val() + $('#CarNumber').val()
    function GetItems(callback) {
        $('body').append(Loading());
        var formData = $('#formSearchSale').serialize();
        $.ajax({
            url: burl + '/find/sale',
            type: 'POST',
            data: formData
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
                var disedit = 'disabled';
                var disdel = 'disabled="disabled"';
                var rowcolor = '';
                var remain = (item.SubTotal-item.PayAmount);
                if(item.IsOrder == 1)
                {
                    rowcolor = 'info';
                    if(item.PayAmount == 0)
                    {
                        disedit = '';
                        disdel = '';
                    }
                }else if(remain == 0){
                    rowcolor = 'success';
                }
                element += '<tr class="' + rowcolor +'" data-id="' + item.Id + '">' +
                '<td><a href="'+ burl +'/create/sale/'+ item.customer.Id +'">' + item.customer.CustomerName + '</a></td>' +
                '<td>' + item.item.ItemName + '</td>' +
                '<td class="center">' + CDate(item.SaleDate) + '</td>' +
                '<td class="center">' + item.CarNumber + '</td>' +
                '<td class="center">' + item.Quantity + '</td>' +
                '<td class="center">' + item.SalePrice + '</td>' +
                '<td class="center subtotal" style="text-align:right;">' + item.SubTotal + '</td>' +
                '<td class="center payamount" style="text-align:right;">' + item.PayAmount + '</td>' +
                '<td class="center remain" style="text-align:right;">' + remain + '</td>' +
                '<td class="center no-print">' +
                '<button type="button" class="btn btn-danger btn-e delete" ' + disdel + '><i class="fa fa-trash-o" aria-hidden="true"></i></button>' +
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
        var displayTitle = 'តារាងការលក់ចេញ';
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
                url: burl + '/delete/sale/' + id,
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
