(function(){
    $('.list-group-item:eq(10)').addClass('active');
    ViewItem();

    function ViewItem(){
        GetItems(function(items){
            RenderTable(items, function(element){
                $('#userTable tbody').html(element);
            });
        });
    }

    function GetItems(callback) {
        $('body').append(Loading());
        $.ajax({
            url: burl + '/find/user',
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

    function RenderTable(users, callback){
        var element = '';
        if((users != null) && (users.length > 0)){
            $.each(users, function(index, item){
                element += '<tr data-id="' + item.Id + '">' +
                '<td>' + item.Name + '</td>' +
                '<td>' + item.Email + '</td>' +
                '<td class="center">' + item.DateCreated + '</td>' +
                '<td class="center">' +
                '<button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>' +
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
                url: burl+'/delete/user/'+id,
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
