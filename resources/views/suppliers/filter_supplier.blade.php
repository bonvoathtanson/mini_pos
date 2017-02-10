@extends('layouts.admin')
@section('content')
<div class="box-title">
    <i class="fa fa-plus-square" aria-hidden="true"></i> ជ្រើសរើសអ្នកផ្គត់ផ្គង់
</div>
<form class="form-horizontal" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ស្វែងរកអ្នកផ្គត់ផ្គង់</label>
                <div class="col-sm-1" style="width:320px;">
                    <input type="text" id="inputsearch" class="form-control btn-default" placeholder="ស្វែករកតាម លេខកូដ ឈ្មោះ លេខទូស័ព្ទ">
                </div>
                <div class="col-sm-1" style="width:220px; padding-left:0;">
                    <button type="button" id="btnsearch" class="btn btn-success">ស្វែងរក</button>
                    <a href="{{url('/create/supplier')}}" class="btn btn-primary">បន្ថែមអ្នកផ្គត់ផ្គង់ថ្មី</a>
                </div>
            </div>
        </div>
    </div>
    <div class="box-table" style="display:none;">
        <table id="supplerTable" class="table table-bordered table-hovere">
            <thead>
                <tr class="bg-white">
                    <th>លេខកូដ</th>
                    <th>ឈ្មោះ</th>
                    <th class="center">លេខទូរសព្ទ</th>
                    <th style="width:170px;"></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="box-null" style="font-size:14pt; color:red; display:none;">
        ទិន្នន័យស្វែកមិនមាន
    </div>
</form>
@endsection
@section('script')
<script type="text/javascript">
(function(){

    $('.list-group-item:eq(8)').addClass('active');
    $('body').on('click', '#btnsearch', function(){
        var value = $('#inputsearch').val();
        if(value != '' && value != null){
            Search();
        }else{
            $('.box-null').show();
            $('.box-table').hide();
            $('#supplerTable tbody tr').remove();
        }
    });

    $('body').on('keypress', '#inputsearch', function(event){
        if(event.which == 13) {
            var value = $('#inputsearch').val();
            if(value != '' && value != null){
                Search();
            }else{
                $('.box-null').show();
                $('.box-table').hide();
                $('#supplerTable tbody tr').remove();
            }
        }
    });

    function Search(){
        GetItems(function(suppliers){
            RenderTable(suppliers, function(element){
                if(element != '' && element != null)
                {
                    $('.box-null').hide();
                    $('.box-table').show();
                }else{
                    $('.box-null').show();
                    $('.box-table').hide();
                }
                $('#supplerTable tbody').html(element);
            });
        });
    }

    function GetItems(callback) {
        $('body').append(Loading());
        var requestUrl = burl + '/filter/supplier/' + $('#inputsearch').val();
        $.ajax({
            url: requestUrl,
            type: 'GET',
            dataType: 'JSON',
            contentType: 'application/json; charset=utf-8',
        }).done(function (data) {
            console.log(data);
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
                                '<td>' + item.SupplierCode + '</td>' +
                                '<td><a href="' + burl + '/detail/supplier/' + item.Id + '">' + item.SupplierName + '</a></td>' +
                                '<td class="center">' + item.PhoneNumber + '</td>' +
                                '<td class="center">' +
                                    '<a href="' + burl + '/create/import/' + item.Id + '" class="btn btn-success btn-e">ទិញចូល</a> ' +
                                    '<a href="' + burl + '/create/expanse/' + item.Id + '" class="btn btn-danger btn-e">សងលុយគេ</a>' +
                                '</td>'
                            '</tr>';
            });
        }
        if(typeof callback == 'function'){
            callback(element);
        }
    }
})();
</script>
@endsection
