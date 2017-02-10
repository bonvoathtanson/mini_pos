(function(){
    
    $('.list-group-item:eq(7)').addClass('active');
    $('body').on('focus', '#customerName', function(){
        $('#searchModal').modal({
            backdrop: 'static'
        });
    });

    $('#searchModal').on('shown.bs.modal', function (e) {
        $('#customerNameSearch').focus();
    });

    $('#searchModal').on('hidden.bs.modal', function (e) {
        $('#customerNameSearch').val('');
    });

    $('body').on('click', '#btnSearchNameCustomer', function(){
        Search();
    });

    $('body').on('keypress', '#customerNameSearch', function(event){
        if(event.which == 13) {
            Search();
        }
    });

    function Search(){
        var keyword = $('#customerNameSearch').val();
        GetItemsCustomer(keyword, function(customers){
            RenderTableCustomer(customers, function(element){
                $('#customerTable tbody').html(element);
            });
        });
    }
    $('body').on('click','#btnPrint',function(){
        var displayTitle = 'តារាងចំណូល';
        var elem = $('.container-A4').html();
        var option = {};
        Print(displayTitle,option, elem);
    });

    function GetItemsCustomer(keyword, callback) {
        $('body').append(Loading());
        var requestUrl = burl + '/filter/customer/' + keyword;
        $.ajax({
            url: requestUrl,
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

    function RenderTableCustomer(customers, callback){
        var element = '';
        if((customers != null) && (customers.length > 0)){
            $.each(customers, function(index, item){
                element += '<tr>' +
                '<td>' + item.CustomerCode + '</td>' +
                '<td>' + item.CustomerName + '</td>' +
                '<td class="center">' + item.PhoneNumber + '</td>' +
                '<td class="center">' +
                '<a data-id="' + item.Id + '" data-name="' + item.CustomerName + '" href="javascript:void(0)" class="btn btn-info btn-e selected">ជ្រើសរើស</a> ' +
                '</td>'
                '</tr>';
            });
        }
        if(typeof callback == 'function'){
            callback(element);
        }
    }

    $('body').on('click','.selected',function(){
        var customerName = $(this).attr('data-name');
        var customerId   = $(this).attr('data-id');
        $('#customerName').val(customerName);
        $('#customerId').val(customerId);
        ViewIncome();
        $('#searchModal').modal('hide');
    });

    $('#incomeFromDate,#incomeToDate').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $("#incomeFromDate").on("dp.change", function (e) {
         $('#incomeToDate').data("DateTimePicker").minDate(e.date);
    });

    $("#incomeToDate").on("dp.change", function (e) {
         $('#incomeFromDate').data("DateTimePicker").maxDate(e.date);
    });
    var dateFrom = moment().format('YYYY-MM-1');
    var dateTo   = moment().format('YYYY-MM-DD');

    $('#incomeFromDate').val(dateFrom);
    $('#incomeToDate').val(dateTo);

    $('#incomeFromDate').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: moment()
    });

    $('#incomeToDate').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: moment()
    });

    //Function click on button search
    $('body').on('click', '#btnsearch', function () {
        var customerId   = $('#customerId').val();
        var incomeFormDate = $('#incomeFromDate').val();
        var incomeToDate   = $('#incomeToDate').val();
        if( customerId !='' || incomeFormDate != '' || incomeToDate != ''){
            ViewIncome();
        }else{
            $('.box-null').show();
            $('#totalamount').text('0.00');
            $('#incomeTable tbody tr').remove();
        }
    });

    //Function click on button reset
    $('body').on('click', '#btnClear', function () {
        $('#customerId').val('');
        $('#customerName').val('');
        ViewIncome();
    });

    ViewIncome();

    function ViewIncome(){
        GetIncome(function(incomes){
            RenderTableIncome(incomes, function(element, totalamount){
                if(element != '' || element != null)
                {
                    $('.box-null').hide();
                }else{
                    $('.box-null').show();
                }
                $('#incomeTable tbody').html(element);
                $('#totalamount').text(totalamount + '.00');
            });
        });
    }

    function GetIncome(callback) {
        $('body').append(Loading());
        var formIncome = $('#formSearchIncome').serialize();
        $.ajax({
            url: burl + '/find/income',
            type: 'POST',
            data: formIncome
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

    function RenderTableIncome(incomes, callback){
        var element = '';
        var totalamount =0;
        if((incomes != null) && (incomes.length > 0)){
            $.each(incomes, function(index, item){
                var name = '';
                if(item.customer != null){
                    name = item.customer.CustomerName;
                }
                var type = 'ចំណូលផ្សេងៗ';
                if(item.IncomeType != 0){
                    type = 'ចំណូលកាលក់';
                }
                element += '<tr data-id="' + item.Id + '">' +
                '<td>' + moment(item.IncomeDate).format('DD-MM-YYYY') + '</td>' +
                '<td>' + name + '</td>' +
                '<td class="center">' + item.Description + '</td>' +
                '<td style="text-align:right;">' + item.TotalAmount + '</td>' +
                '<td class="center no-print">' +
                '<button type="button" class="btn btn-danger btn-e delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>' +
                '</td>'
                '</tr>';
                totalamount += parseInt(item.TotalAmount);
            });
        }
        if(typeof callback == 'function'){
            callback(element, totalamount);
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
                url: burl + '/delete/income/' + id,
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
