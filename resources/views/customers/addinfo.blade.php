@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
    <i class="fa fa-plus-square" aria-hidden="true"></i> បញ្ចូលព័ត៏អ្នកសួរព័ត៍មាន
</div>
<form id="formInfo" class="form-horizontal" method="POST" onsubmit="return false;">
    {{ csrf_field() }}
    <input type="hidden" id="customerId" name="CustomerId" value="{{$customer->Id}}">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ឈ្មោះអតិជិជន</label>
                <div class="col-sm-1" style="width:300px;">
                    <input type="text" id="customerName" class="form-control btn-default" value="{{$customer->CustomerName}}">
                </div>
                <div class="col-sm-1" style="width:280px; padding-left:0;">
                    <a href="javascript:void(0);" class="btn btn-success customer">ជ្រើសរើសអតិថិជន</a>
                    <a href="{{url('/create/customer')}}" class="btn btn-primary">បន្ថែមអតិថិជនថ្មី</a>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">អស័យដ្ឋាន</label>
                <div class="col-sm-1" style="width:560px;">
                    <input type="text" class="form-control btn-default" readonly value="{{$customer->Address}}">
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ថ្ងៃសួរ</label>
                <div class="col-sm-1" style="width:220px;">
                    <input type="text" id="askdate" name="AskDate" class="form-control btn-default">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ថ្ងៃបញ្ជាក់</label>
                <div class="col-sm-1" style="width:220px;">
                    <input type="text" id="confirmdate" name="ConfirmDate" class="form-control btn-default">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">បរិយាយ</label>
                <div class="col-sm-1" style="width:560px;">
                    <input type="text" name="Description" value="" class="form-control">
                </div>
            </div>
            <div id="info-reason" class="form-group" style="display:none;">
                <label class="col-sm-1 control-label" style="width:150px;">ហេតុផល</label>
                <div class="col-sm-1" style="width:560px;">
                    <input type="text" id="Reason" name="Reason" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">កំណត់ចំណាំ</label>
                <div class="col-sm-2">
                    <select class="form-control btn-default" id="StatusId" name="StatusId" style="font-size:10pt;padding:3px">
                        <option value="1">រង់ចាំ</option>
                        <option value="2">បោះបង់</option>
                        <option value="3">ជោគជ័យ</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;"></label>
                <div class="col-sm-1" style="width:300px;">
                    <button type="submit" id="save" class="btn btn-success">រក្សាទុក</button>
                    <a href="{{url('/view/askinfo')}}" class="btn btn-danger">បោះបង់</a>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="formCustomer" class="form-horizontal" onsubmit="return false;">
    {{ csrf_field() }}
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span id="itemname" style="color:#0856ab; font-weight:bold;">ស្វែងរកឈ្មោះអតិថិជន</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="min-height:350px;">
                    <div style="margin-bottom:3px;">
                        <div class="input-group">
                            <input type="text" id="customerNameSearch" name="customerNameSearch" class="form-control btn-default" placeholder="ស្វែករកតាម លេខកូដ ឈ្មោះ លេខទូស័ព្ទ">
                            <span class="input-group-btn">
                                <button class="btn btn-success" id="btnSearchNameCustomer" style="border:1px solid #419641;" type="button">ស្វែងរក</button>
                            </span>
                        </div>
                    </div>
                    <div class="box-table">
                        <table id="customerTable" class="table table-bordered table-hovered">
                            <thead>
                                <tr class="bg-white">
                                    <th>លេខកូដ</th>
                                    <th>ឈ្មោះ</th>
                                    <th class="center">លេខទូរស័ព្ទ</th>
                                    <th style="width:90px;"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="box-null-customer center" style="font-size:11pt; color:red; display:none;">
                        <div class="form-group">
                            <label class="col-sm-1 control-label" style="width:180px;​padding-left:0px">ទិន្នន័យស្វែ​ងរកមិនមាន</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
<script src="{{url('/script/customers/info.add.js')}}" charset="utf-8"></script>
<script type="text/javascript">
(function(){

    $('body').on('focus', '#customerName', function(){
        $('#myModal').modal({
            backdrop: 'static'
        });
    });

    $('body').on('click', '.customer', function(){
        $('#myModal').modal({
            backdrop: 'static'
        });
    });

    //Function On selected customer name
    $('body').on('click','.selected',function(){
        var customerId   = $(this).attr('data-id');
        window.location.href = burl + '/create/askinfo/' + customerId;
        $('#myModal').modal('hide');
    });
    $('#myModal').on('shown.bs.modal', function (e) {
        $('#customerNameSearch').focus();
    });

    $('#myModal').on('hidden.bs.modal', function (e) {
        $('#customerNameSearch').val('');
    });

    $('body').on('click', '#btnSearchNameCustomer', function(){
        var value = $('#customerNameSearch').val();
        if(value != '' && value != null){
            Search();
        }else{
            $('.box-null-customer').show();
            $('.box-table').hide();
            $('#customerTable tbody tr').remove();
        }
    });

    $('body').on('keypress', '#customerNameSearch', function(event){
        if(event.which == 13) {
            var value = $('#customerNameSearch').val();
            if(value != '' && value != null){
                Search();
            }else{
                $('.box-null-customer').show();
                $('.box-table').hide();
                $('#customerTable tbody tr').remove();
            }
        }
    });

    function Search(){
        GetItems(function(customers){
            RenderTable(customers, function(element){
                if(element != '' && element != null)
                {
                    $('.box-null-customer').hide();
                    $('.box-table').show();
                }else{
                    $('.box-null-customer').show();
                    $('.box-table').hide();
                }
                $('#customerTable tbody').html(element);
            });
        });
    }

    function GetItems(callback) {
        $('body').append(Loading());
        var requestUrl = burl + '/filter/customer/' + $('#customerNameSearch').val();
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

    function RenderTable(customers, callback){
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
})();
</script>
@endsection
