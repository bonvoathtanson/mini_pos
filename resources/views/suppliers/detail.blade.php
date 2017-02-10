@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
  <i class="fa fa-plus-square" aria-hidden="true"></i> ព័ត៍មានលំអិតអ្នកផ្គត់ផ្គង់ឈ្មោះ [{{$supplier->SupplierName}}]
</div>
<form id="formSale" class="form-horizontal" onsubmit="return false;">
    {{ csrf_field() }}
    <input type="hidden" name="CustomerId" value="{{$supplier->Id}}">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ឈ្មោះអ្នកផ្គត់ផ្គង់</label>
                <div class="col-sm-1" style="width:300px;">
                    <input type="text" class="form-control btn-default" id="supplyName" value="{{$supplier->SupplierName}}">
                </div>
                <div class="col-sm-1" style="width:280px; padding-left:0;">
                    <a href="javascript:void(0)"  class="btn btn-success supply">ជ្រើសរើសអ្នកផ្គត់ផ្គង់​</a>
                    <a href="{{url('/create/supplier')}}" class="btn btn-primary">បន្ថែមអ្នកផ្គត់ផ្គង់ថ្មី</a>
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
    <div class="row" style="margin-bottom:5px;">
        <div class="col-sm-12" style="padding-left:0;">
            <div class="col-sm-1" style="width:200px;">

            </div>
            <div class="pull-right">
                <a href="{{url('/create/import').'/'.$supplier->Id}}" class="btn btn-primary">បន្ថែមកានាំចូល</a>
                <a href="{{url('/create/expanse').'/'.$supplier->Id}}" class="btn btn-danger">បង់លុយ</a>
            </div>
        </div>
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#box-tap1" class="font-M1" aria-controls="home" role="tab" data-toggle="tab">ទំនិញមិនទាន់ដឹកចូល</a></li>
            <li role="presentation"><a href="#box-tap2" class="font-M1" aria-controls="home" role="tab" data-toggle="tab">មិនទាន់ទូទាត់</a></li>
            <li role="presentation"><a href="#box-tap3" class="font-M1" aria-controls="home" role="tab" data-toggle="tab">ទូទាត់ហើយ</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="box-tap1">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-white">
                            <th>មុខទំនិញ</th>
                            <th class="center">កាលបរិច្ឆេទបញ្ជាទិញ</th>
                            <th class="center">ចំនួន</th>
                            <th class="center">ត្រូវដឹកចូល</th>
                            <th style="width:25px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transfers as $index => $value): ?>
                            <tr data-id="{{$value->Id}}">
                                <td>{{$value->Item->ItemName}}</td>
                                <td class="center">{{date_format(date_create($value->SaleDate), 'Y-m-d H:i')}}</td>
                                <td class="center">{{$value->Quantity}}</td>
                                <td class="center">{{date_format(date_create($value->SaleDate), 'Y-m-d ម៉ោង H:i')}}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-e transfer">ដឹកចូល</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="box-tap2">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-white">
                            <th>មុខទំនិញ</th>
                            <th class="center">កាលបរិច្ឆេទលក់</th>
                            <th class="center">ចំនួន</th>
                            <th class="center">តំលៃលក់</th>
                            <th style="text-align:right;">ទឹកប្រាក់សរុប</th>
                            <th style="text-align:right;">ទឹកប្រាក់បង់</th>
                            <th style="text-align:right;">ទឹកនៅសល់</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($oncredits as $key => $value): ?>
                            <tr>
                                <td>{{$value->Item->ItemName}}</td>
                                <td class="center">{{date_format(date_create($value->SaleDate), 'Y-m-d H:i')}}</td>
                                <td class="center">{{$value->Quantity}}</td>
                                <td class="center">{{$value->SalePrice}}</td>
                                <td style="text-align:right;">{{$value->SubTotal}}</td>
                                <td style="text-align:right;">{{$value->PayAmount}}</td>
                                <td style="text-align:right;">{{$value->SubTotal - $value->PayAmount}}</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="box-tap3">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-white">
                            <th>មុខទំនិញ</th>
                            <th>កាលបរិច្ឆេទលក់</th>
                            <th class="center">លេខឡាន</th>
                            <th class="center">ចំនួន</th>
                            <th class="center">តំលៃលក់</th>
                            <th style="text-align:right;">ចំនួនទឹកប្រាក់</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($onpayoffs as $key => $value): ?>
                            <tr>
                                <td>{{$value->Item->ItemName}}</td>
                                <td class="center">{{date_format(date_create($value->SaleDate), 'Y-m-d H:i')}}</td>
                                <td class="center">{{$value->CarNumber}}</td>
                                <td class="center">{{$value->Quantity}}</td>
                                <td class="center">{{$value->SalePrice}}</td>
                                <td style="text-align:right;">{{$value->SubTotal}}</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
$('.list-group-item:eq(6)').addClass('active');
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
        window.location.href = burl +  '/detail/supplier/' + supplyId;
        $('#myModal').modal('hide');
    });
</script>
<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
@endsection
