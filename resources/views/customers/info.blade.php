@extends('layouts.admin')
@section('content')
<div class="box-title">
    <i class="fa fa-list" aria-hidden="true"></i> តារាងអ្នកសួរព័ត៍មាន
</div>
<div class="row memu-bar">
    <div class="col-sm-12">
        <div class="pull-right">
            <a href="{{url('/view/selectcustomer')}}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> ជ្រើសរើសអតិថិជន</a>
        </div>
    </div>
</div>
<form id="formCustomerAsk" method="post" onsubmit="return false;">
    {{ csrf_field() }}
    <input type="hidden" id="customerId" name="customerId" value="">
    <input type="hidden" id="statusTypeId" name="statusTypeId" value="">
    <div class="panel panel-default" style="width:100%;padding:5px">
        <div class="panel-body">
            <div class="form-group">
                <div class="col-sm-1" style="width:110px;margin-top:5px; padding-left:0;">ឈ្មោះអតិថិជន</div>
                <div class="col-sm-1" style="width:150px;padding-left:0px">
                    <input type="text" id="customerName" name="customerName" class="form-control btn-default" placeholder="ឈ្មោះអតិថិជន">
                </div>
                    <div class="col-sm-1" style="width:150px; padding-left:0px">
                        <select class="form-control btn-default" style="padding:3px" name="statusTypeId" id="statusTypeId">
                            <option value="1">រង់ចាំ</option>
                                <option value="2" name="">បោះបង់</option>
                                <option value="3" name="">ជោគជ័យ</option>
                        </select>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-sm-12">
        <table id="customerTableAsk" class="table table-bordered table-hover">
            <thead>
                <tr class="bg-white">
                    <th>ឈ្មោះអតិថិជន</th>
                    <th class="center">ថ្ងៃសួរព័ត៍មាន</th>
                    <th class="center">ថ្ងៃសួរបញ្ជាក់</th>
                    <th>បរិយាយ</th>
                    <th class="center"><span id="viewreason"></span></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="box-null" style="font-size:14pt; color:red; padding-left:15px; display:none;">
        ទិន្នន័យស្វែងរកមិនមាន
    </div>
</div>
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
<script src="{{url('/script/customers/info.index.js')}}" charset="utf-8"></script>
<script type="text/javascript">
(function(){

    $('body').on('focus', '#customerName', function(){
        $('#myModal').modal({
            backdrop: 'static'
        });
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
