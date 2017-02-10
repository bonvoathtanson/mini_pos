(function(){
    
    $('.list-group-item:eq(5)').addClass('active');
    ViewItem();

    function ViewItem(){
        GetItems(function(customers){
            RenderTable(customers, function(element){
                $('#customerTable tbody').html(element);
            });
        });
    }

    function GetItems(callback) {
        $('body').append(Loading());
        $.ajax({
            url: burl + '/find/customer',
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
            $.each(customers, function(index, item){
                var sex = 'ប្រុស';
                if(item.Sex == 2){
                    sex = 'ស្រី';
                }
                element += '<tr data-id="' + item.Id + '">' +
                                '<td>' + item.CustomerCode + '</td>' +
                                '<td><a href="'+ burl +'/create/sale/'+ item.Id +'">' + item.CustomerName + '</a></td>' +
                                '<td class="center">' + sex + '</td>' +
                                '<td class="center">' + item.PhoneNumber + '</td>' +
                                '<td class="center">' + item.Address + '</td>' +
                                '<td class="center">' +
                                    '<a href="' + burl + '/edit/customer/' + item.Id + '" class="btn btn-success btn-e"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ' +
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
                url: burl + '/delete/customer/' + id,
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
