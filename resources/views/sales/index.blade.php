@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
  <i class="fa fa-list" aria-hidden="true"></i>​​ តារាងការលក់ចេញ
</div>
<div class="row memu-bar">
  <div class="col-sm-12">
    <div class="pull-right">
        <a href="{{url('/create/sale')}}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> លក់ចេញ</a>
        <a href="{{url('/create/income')}}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> សងលុយ</a>
        <a href="{{url('/view/selectcustomer')}}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> ជ្រើសរើសអតិថិជន</a>
        <a href="javascript:void(0)" id="btnPrint"  class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> បោះពុម្ភ</a>
    </div>
  </div>
</div>
<form id="formSearchSale" method="post" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="panel panel-default" style="width:100%;padding:5px">
        <div class="panel-body">
            <div class="form-group">
                <div class="col-xm-1" style="width:280px; padding-left:0px;">
                    <div class="input-group">
                        <input type="text" id="customerName" name="customerName" class="form-control btn-default" placeholder="ជ្រើសរើសអតិថិជន">
                        <span class="input-group-btn">
                            <button id="btnClear" class="btn btn-success" style="border:1px solid #419641;" type="button">សំអាត</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1" style="width:135px; padding-left:0px;">
                    <input type="text" id="saleFromDate" name="saleFromDate" class="form-control btn-default" placeholder="ថ្ងៃខែឆ្នាំលក់">
                </div>
                <div class="col-sm-1" style="width:25px;margin-top:5px; padding-left:0;">ដល់</div>
                <div class="col-sm-1" style="width:135px;">
                    <input type="text" id="saleToDate" name="saleToDate" class="form-control btn-default" placeholder="ថ្ងៃខែឆ្នាំលក់">
                </div>
                <div class="col-sm-1" style="width:75px;margin-top:5px; padding-left:0;">លេខឡាន</div>
                    <div class="col-sm-1" style="width:150px; padding-left:0px">
                        <select class="form-control btn-default" style="padding:3px" name="carNumber" id="carNumber">
                            <option value="">ជ្រើសលេខឡាន</option>
                            <?php foreach ($cars as $index => $value): ?>
                                <option value="{{$value->Id}}" name="{{$value->CarNo}}">{{$value->CarNo}}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <div class="col-sm-1" style="width:220px; padding-left:0;">
                    <button type="button" id="btnsearch" class="btn btn-success">ស្វែងរក</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="hdfcustomerId" name="hdfcustomerId" value="">
    <input type="hidden" id="hdfcarNumber" name="hdfcarNumber" value="">
</form>
<div class="row">
  <div class="col-sm-12 container-A4">
    <table id="saleTable" class="table table-bordered table-hover">
      <thead class="print-header">
        <tr class="bg-white font-M1">
          <th>ឈ្មោះអតិថិជន</th>
          <th>មុខទំនិញ</th>
          <th>កាលបរិច្ឆេទលក់</th>
          <th>លេខឡាន</th>
          <th>ចំនួន</th>
          <th>តំលៃលក់</th>
          <th style="text-align:right;">ទឹកប្រាក់សរុប</th>
          <th style="text-align:right;">ប្រាក់ទទួល</th>
          <th style="text-align:right;">ប្រាក់នៅសល់</th>
          <th class="center no-print" style="width:40px;"></th>
        </tr>
      </thead>
      <tbody class="print-body"></tbody>
      <tfoot>
          <tr>
              <td colspan="6" style="text-align:right;">សរុប</td>
              <td style="text-align:right;">
                  <span id="totalamount" style="color:blue; font-weight:bold;">0.00</span>
              </td>
              <td style="text-align:right;border:none;">
                  <span id="payamount" style="color:blue; font-weight:bold;">0.00</span>
              </td>
              <td style="text-align:right;border-bottom:none;">
                  <span id="remain" style="color:blue; font-weight:bold;">0.00</span>
              </td>
              <td style="text-align:right;" class="no-print">
              </td>
          </tr>
      </tfoot>
    </table>
    <div class="print-footer">

    </div>
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
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
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
<script src="{{url('/script/sales/sale.index.js')}}" charset="utf-8"></script>
<script src="{{url('/script/print/print.js')}}" charset="utf-8"></script>
@endsection
