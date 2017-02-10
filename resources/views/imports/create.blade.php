@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
  <i class="fa fa-plus-square" aria-hidden="true"></i> កំណត់ត្រាកានាំចូលពីអ្នកផ្គត់ផ្គង់ឈ្មោះ [{{$supplier->SupplierName}}]
</div>
<form id="formImport" class="form-horizontal" onsubmit="return false;">
    {{ csrf_field() }}
    <input type="hidden" name="SupplierId" value="{{$supplier->Id}}">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ឈ្មោះអ្នកផ្គត់ផ្គង់​</label>
                <div class="col-sm-1" style="width:300px;">
                    <input type="text" class="form-control btn-default" value="{{$supplier->SupplierName}}">
                </div>
                <div class="col-sm-1" style="width:280px; padding-left:0;">
                    <a href="javascript:void(0)"  class="btn btn-success supply">ជ្រើសរើសអ្នកផ្គត់ផ្គង់​</a>
                    <a href="{{url('/create/customer')}}" class="btn btn-primary">បន្ថែមអ្នកផ្គត់ផ្គង់ថ្មី</a>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">អាស័យដ្ឋាន</label>
                <div class="col-sm-1" style="width:580px;">
                    <input type="text" class="form-control btn-default" readonly value="{{$supplier->Address}}">
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">មុខទំនិញ</label>
                <div class="col-sm-1" style="width:350px;">
                    <select class="form-control btn-default" style="padding:3px" name="ItemId" id="itemid">
                        <option value=""></option>
                        <?php foreach ($items as $index => $value): ?>
                            <option value="{{$value->Id}}" price="{{$value->SalePrice}}">{{$value->ItemName}}</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">កាលបរិច្ឆេទទិញ</label>
                <div class="col-sm-1" style="width:220px;">
                    <input type="text" id="importdate" name="ImportDate" class="form-control btn-default">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ចំនួន</label>
                <div class="col-sm-1" style="width:150px;">
                    <input type="text" id="quantity" min="1" name="Quantity" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">តំលៃលក់ចេញ</label>
                <div class="col-sm-1" style="width:150px;">
                    <input type="text" id="saleprice" name="SalePrice" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">លេខឡាន</label>
                <div class="col-sm-1" style="width:200px;">
                    <input type="text" id="carnumber" name="CarNumber" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ដឹកចូល</label>
                <div class="col-sm-1" style="width:200px;">
                    <select class="form-control btn-default" style="padding:3px" id="typeid" name="IsOrder">
                        <option value="0">ដឹកចូលភ្លាម</option>
                        <option value="1">ដឹកចូលពេលក្រោយ</option>
                    </select>
                </div>
            </div>
            <div id="group-date" class="form-group" style="display:none;">
                <label class="col-sm-1 control-label" style="width:150px;">កាលបរិច្ឆេទដឹក</label>
                <div class="col-sm-1" style="width:350px;">
                    <input type="text" id="transferdate" name="TransferDate" class="form-control btn-default">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ទឹកប្រាក់សរុប</label>
                <div class="col-sm-1" style="width:350px;">
                    <input type="text" id="totalamount" name="TotalAmount" class="form-control btn-default" readonly value="0">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">បង់ប្រាក់ចំនួន</label>
                <div class="col-sm-1" style="width:350px;">
                    <input type="text" id="payamount" name="PayAmount" class="form-control" value="0">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;"></label>
                <div class="col-sm-1" style="width:350px;">
                    <button type="submit" class="btn btn-success" id="save">រក្សាទុក</button>
                    <a href="{{url('/view/import')}}" class="btn btn-danger">បោះបង់</a>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="formSupply" class="form-horizontal" onsubmit="return false;">
    {{ csrf_field() }}
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span id="itemname" style="color:#0856ab; font-weight:bold;">ស្វែងរកឈ្មោះអ្នកផ្គត់ផ្គង់</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="min-height:350px;">
                    <div style="margin-bottom:3px;">
                        <div class="input-group">
                            <input type="text" id="supplyNameSearch" name="supplyNameSearch" class="form-control btn-default" placeholder="ស្វែករកតាម លេខកូដ ឈ្មោះ លេខទូស័ព្ទ">
                            <span class="input-group-btn">
                                <button class="btn btn-success" id="btnSearchNameSupply" style="border:1px solid #419641;" type="button">ស្វែងរក</button>
                            </span>
                        </div>
                    </div>
                    <div class="box-table">
                        <table id="supplyTable" class="table table-bordered table-hovered">
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
                    <div class="box-null-supply center" style="font-size:11pt; color:red; display:none;">
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
<script type="text/javascript">

    $('.list-group-item:eq(8)').addClass('active');

    $('body').on('focus', '#supplyName', function(){
        $('#myModal').modal({
            backdrop: 'static'
        });
    });
    $('body').on('click', '.supply', function(){
        $('#myModal').modal({
            backdrop: 'static'
        });
    });
    $('#myModal').on('shown.bs.modal', function (e) {
        $('#supplyNameSearch').focus();
    });

    $('#myModal').on('hidden.bs.modal', function (e) {
        $('#supplyNameSearch').val('');
    });

    $('body').on('click', '#btnSearchNameSupply', function(){
        var value = $('#supplyNameSearch').val();
        if(value != '' && value != null){
            Search();
        }else{
            $('.box-null-supply').show();
            $('.box-table').hide();
            $('#supplyTable tbody tr').remove();
        }
    });

    $('body').on('keypress', '#supplyNameSearch', function(event){
        if(event.which == 13) {
            var value = $('#supplyNameSearch').val();
            if(value != '' && value != null){
                Search();
            }else{
                $('.box-null-supply').show();
                $('.box-table').hide();
                $('#supplyTable tbody tr').remove();
            }
        }
    });

    function Search(){
        GetItems(function(suppliers){
            RenderTable(suppliers, function(element){
                if(element != '' && element != null)
                {
                    $('.box-null-supply').hide();
                    $('.box-table').show();
                }else{
                    $('.box-null-supply').show();
                    $('.box-table').hide();
                }
                $('#supplyTable tbody').html(element);
            });
        });
    }

    function GetItems(callback) {
        $('body').append(Loading());
        var requestUrl = burl + '/filter/supplier/' + $('#supplyNameSearch').val();
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
                element += '<tr>' +
                                '<td>' + item.SupplierCode + '</td>' +
                                '<td>' + item.SupplierName + '</td>' +
                                '<td class="center">' + item.PhoneNumber + '</td>' +
                                '<td class="center">' +
                                    '<a data-id="' + item.Id + '" data-name="' + item.SupplierName + '" href="javascript:void(0)" class="btn btn-info btn-e selected">ជ្រើសរើស</a> ' +
                                '</td>'
                            '</tr>';
            });
        }
        if(typeof callback == 'function'){
            callback(element);
        }
    }
    //Function On selected customer name
    $('body').on('click','.selected',function(){
        var supplyId = $(this).attr('data-id');
        window.location.href = burl +  '/create/import/' + supplyId;
        $('#myModal').modal('hide');
    });
</script>
<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
<script src="{{url('/script/imports/import.add.js')}}" charset="utf-8"></script>
@endsection
