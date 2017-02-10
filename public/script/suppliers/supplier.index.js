(function(){

    $('.list-group-item:eq(6)').addClass('active');
    $('body').on('click', '#btnsearch', function(){
        var value = $('#inputsearch').val();
        if(value != '' && value != null){
            Search();
        }
    });

    $('body').on('keypress', '#inputsearch', function(event){
        if(event.which == 13) {
            var value = $('#inputsearch').val();
            if(value != '' && value != null){
                Search();
            }
        }
    });
    Search();
    function Search(){
        GetItems(function(customers){
            RenderTable(customers, function(element){
                if(element != '' && element != null)
                {
                    $('.box-null').hide();
                    $('.box-table').show();
                }else{
                    $('.box-null-customer').show();
                    $('.box-table').hide();
                }
                $('#supplierTable tbody').html(element);
            });
        });
    }

    function GetItems(callback) {
        $('body').append(Loading());
        var value = $('#inputsearch').val();
        if(value ==''){
            value ='empty';
        }
        var requestUrl = burl + '/filter/supplier/' + value;
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

    function RenderTable(suppliers, callback){
        var element = '';
        if((suppliers != null) && (suppliers.length > 0)){
            $.each(suppliers, function(index, item){
                var sex = 'ប្រុស';
                if(item.Sex == 2){
                    sex = 'ស្រី';
                }
                element += '<tr data-id="' + item.Id + '">' +
                                '<td>' + item.SupplierCode + '</td>' +
                                '<td><a href="' + burl + '/detail/supplier/' + item.Id + '">' + item.SupplierName + '</a></td>' +
                                '<td class="center">' + sex + '</td>' +
                                '<td class="center">' + item.PhoneNumber + '</td>' +
                                '<td class="center">' + item.Address + '</td>' +
                                '<td class="center">' +
                                    '<a href="' + burl + '/edit/supplier/' + item.Id + '" class="btn btn-success btn-e"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ' +
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
                url: burl + '/delete/supplier/' + id,
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
