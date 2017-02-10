@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
  <i class="fa fa-list" aria-hidden="true"></i> តារាងចំណាយ
</div>
<div class="row memu-bar">
  <div class="col-sm-12">
    <div class="pull-right">
      <a href="{{url('/view/selsupplier')}}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> ជ្រើសរើសអ្នកផ្គត់ផ្គង់</a>
          <a href="{{url('/create/otherexpanse')}}" class="btn btn-primary"><i class="fa fa-credit-card" aria-hidden="true"></i> ចំណាយផ្សេងៗ</a>
          <a href="javascript:void(0)" id="btnPrint"  class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> បោះពុម្ភ</a>
    </div>
  </div>
</div>
<form id="formSearchExpanse" method="post" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="panel panel-default" style="width:100%;padding:5px">
        <div class="panel-body">
            <table class="table-ed">
                <tbody>
                    <tr>
                        <td style="width:280px;" colspan="3">
                            <input type="hidden" id="supplyId" name="supplyId" value="">
                            <div class="input-group">
                                <input type="text" id="supplyName" name="supplyName" class="form-control btn-default" placeholder="ជ្រើសរើសអ្នកផ្គត់ផ្គង់">
                                <span class="input-group-btn">
                                    <button class="btn btn-success" id="btnClear" style="border:1px solid #419641;" type="button">សំអាត</button>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:150px;">
                            <div style="position: relative">
                                <input type="text" id="expanseFromDate" name="expanseFromDate" class="form-control btn-default" placeholder="ចាប់ពីថ្ងៃ">
                            </div>
                        </td>
                        <td style="vertical-align:middle;"><span>ដល់</span></td>
                        <td style="width:150px;">
                            <div style="position: relative">
                                <input type="text" id="expanseToDate" name="expanseToDate" class="form-control btn-default" placeholder="ដល់ថ្ងៃ">
                            </div>
                        </td>
                        <td>
                            <button type="button" id="btnsearch" class="btn btn-success">ស្វែងរក</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>
<div class="row">
  <div class="col-sm-12 container-A4">
    <table id="expanseTable" class="table table-bordered table-hover">
      <thead class="print-header">
        <tr class="bg-white font-M1">
          <th>កាលបរិច្ឆេទចំណាយ</th>
          <th>ប្រភេទចំណាយ</th>
          <th class="center">បរិយាយ</th>
          <th class="center">ចំនួនសរុប</th>
          <th class="no-print" style="width:40px;"></th>
        </tr>
      </thead>
      <tbody class="print-body"></tbody>
      <tfoot>
          <tr>
              <td colspan="3" style="text-align:right;">សរុប </td>
              <td style="text-align:right;border-right::solid 1px white;">
                  <span id="totalamount" style="font-weight:bold;">0.00</span>
              </td>
              <td class="no-print" style="text-align:right;">
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
(function(){

    $('body').on('focus', '#supplyName', function(){
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
})();
</script>

<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
<script src="{{url('/script/expanses/expanse.index.js')}}" charset="utf-8"></script>
<script src="{{url('/script/print/print.js')}}" charset="utf-8"></script>
@endsection
