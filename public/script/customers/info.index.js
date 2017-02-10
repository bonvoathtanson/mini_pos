(function(){

    $('.list-group-item:eq(2)').addClass('active');

    $('body').on('click','.selected',function(){
        var statusType = $('#statusTypeId').val();
        var customerId   = $(this).attr('data-id');
        var customerName = $(this).attr('data-name');
        $('#customerName').val(customerName);
        $('#customerId').val(customerId);
        $('#myModal').modal('hide');
        ViewItem();
    });

    $('body').on('change','#statusTypeId',function(){
        var statusType = $(this).find(':selected').attr('value');
        var customerId   = $('#customerId').val();
        $('#customerId').val(customerId);
        $('#statusTypeId').val(statusType);
        ViewItem();
    });

    ViewItem();

    function ViewItem(){
        GetItems(function(customers){
            RenderTable(customers, function(element, reason){
                if(element != '' && element != null)
                {
                    $('.box-null').hide();
                }else{
                    $('.box-null').show();
                }
                $('#customerTableAsk tbody').html(element);
                $('#viewreason').text(reason);
            });
        });
    }

    function GetItems(callback) {
        $('body').append(Loading());
        var dataForm = $('#formCustomerAsk').serialize();
        $.ajax({
            url:  burl + '/find/customerask',
            type: 'POST',
            data: dataForm
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
            var reason =''
            var draw = '';
            var rowcolor = '';
            $.each(customers, function(index, item){
                if(item.StatusId == 1){
                    draw = '<a data-id="' + item.Id + '" href="' + burl + '/edit/editinfo/' + item.Id + '" class="btn btn-success btn-e"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> '
                }
                if(item.StatusId == 2){
                    reason ='ហេតុផល'
                    rowcolor = 'danger';
                    draw = item.Reason
                }
                if(item.StatusId == 3){
                    rowcolor ='success'
                }
                element += '<tr  class="' + rowcolor +'" style="' +  + '" data-id="' + item.Id + '">' +
                                '<td>' + item.customer.CustomerName + '</td>' +
                                '<td class="center">' + moment(item.AskDate).format('DD-MM-YYYY') + '</td>' +
                                '<td class="center">' + moment(item.ConfirmDate).format('DD-MM-YYYY') + '</td>' +
                                '<td class="center">' + item.Description + '</td>' +
                                '<td class="center">' + draw + '</td>'
                            '</tr>';
                    rowcolor ='';
                    draw ='';
            });
        }
        if(typeof callback == 'function'){
            callback(element, reason);
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
