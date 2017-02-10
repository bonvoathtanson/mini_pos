(function(){
    $('.list-group-item:eq(7)').addClass('active');
    $('#incomedate').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: new Date()
    });

    var id = window.location.hash.replace('#', '');
    GetSaleByCustomerId(id);

    $('body').on('focus', '#customername', function(){
        $('#SearchModal').modal({
            backdrop: 'static'
        });
    });
    $('body').on('click', '.customer', function(){
        $('#SearchModal').modal({
            backdrop: 'static'
        });
    });
    $('#SearchModal').on('shown.bs.modal', function (e) {
        $('#customer').focus();
    });

    $('#SearchModal').on('hidden.bs.modal', function (e) {
        $('#customer').val('');
    });

    $('body').on('click', '#btnSearch', function(){
        Search();
    });
    $('body').on('keypress', '[name="FilterText"]', function(event){
        if(event.which == 13) {
            Search();
        }
    });

    $('body').on('click','.selected',function(){
        var customerId = $(this).closest('tr').attr('data-id');
        window.location.hash = '#' + customerId;
        GetSaleByCustomerId(customerId);
        $('#SearchModal').modal('hide');
    });

    function Search(){
        var keyword = $('[name="FilterText"]').val();
        GetCustomer(keyword, function(customers){
            CustomerTable(customers, function(element){
                $('#customerTable tbody').html(element);
            });
        });
    }

    function GetCustomer(keyword, callback) {
        $('body').append(Loading());
        var requestUrl = burl + '/filter/customer/' + keyword;
        $.ajax({
            url: requestUrl,
            type: 'GET',
            dataType: 'JSON',
            contentType: 'application/json; charset=utf-8'
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

    function CustomerTable(customers, callback){
        var element = '';
        if((customers != null) && (customers.length > 0)){
            $.each(customers, function(index, item){
                element += '<tr data-id="' + item.Id + '">' +
                '<td>' + item.CustomerCode + '</td>' +
                '<td>' + item.CustomerName + '</td>' +
                '<td class="center">' + item.PhoneNumber + '</td>' +
                '<td class="center">' +
                '<button type="button" class="btn btn-info btn-e selected">ជ្រើសរើស</button> ' +
                '</td>'
                '</tr>';
            });
        }
        if(typeof callback == 'function'){
            callback(element);
        }
    }

    function GetSaleByCustomerId(customerId) {
        $('body').append(Loading());
        var requestUrl = burl + '/ajax/sale/customer/' + customerId;
        $.ajax({
            url: requestUrl,
            type: 'GET',
            dataType: 'JSON',
            contentType: 'application/json; charset=utf-8',
        }).done(function (data) {
            if(data.IsError == false){
                var customer = data.Data.customer;
                $('#customername').val(customer.CustomerName);
                $('[name="CustomerId"]').val(customerId);
                $('#address').val(customer.Address);
                RenderSale(data.Data.sales, function(element){
                    $('.tableSale table>tbody').html(element);
                    $(':checkbox').iCheck({
                        checkboxClass: 'icheckbox_minimal'
                    });
                    $('input').on('ifChecked', function(event){
                        var select = $(this).closest('tr');
                        var total = parseInt($(select).find('td:eq(7)').text()) + parseInt($('#totalamount').text());
                        $('#totalamount').text(total);
                    });

                    $('input').on('ifUnchecked', function(event){
                        var select = $(this).closest('tr');
                        var total = parseInt($('#totalamount').text()) - parseInt($(select).find('td:eq(6)').text());
                        $('#totalamount').text(total);
                    });
                });
            }
        }).complete(function (data) {
            $('body').find('.loading').remove();
        });
    }

    function RenderSale(sales, callback) {
        var element = '';
        if((sales != null) && (sales.length > 0)){
            $.each(sales, function(index, item){
                var remain = item.SubTotal - item.PayAmount;
                element += '<tr data-id="' + item.Id + '">' +
                '<td class="center"><input type="checkbox" name="SaleIds[]" value="' + item.Id + '"/></td>' +
                '<td>' + item.item.ItemName + '</td>' +
                '<td class="center">' + item.SaleDate + '</td>' +
                '<td class="center">' + item.Quantity + '</td>' +
                '<td class="center">' + item.SalePrice + '</td>' +
                '<td class="center">' + item.SubTotal + '</td>' +
                '<td class="center">' + item.PayAmount + '</td>' +
                '<td style="text-align:right;">' + remain + '</td>' +
                '</tr>';
            });
        }
        if(typeof callback == 'function'){
            callback(element);
        }
    }
})();
