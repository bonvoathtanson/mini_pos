@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
    <i class="fa fa-list" aria-hidden="true"></i>​​ របាយការណ៏ ការចំណាយ
</div>
<form id="formSearchExpanse" method="get" action="{{URL('/find/exportexpanse')}}">
    {{ csrf_field() }}
    <div class="panel panel-default" style="width:100%;padding:5px">
        <div class="panel-body">
            <div class="form-group">
                <div class="col-xm-1" style="width:280px; padding-left:0px;">
                    <div class="input-group">
                        <input type="text" id="supplyName" name="supplyName" class="form-control btn-default supply" placeholder="ឈ្មោះអ្នកផ្គត់ផ្គង់​">
                        <span class="input-group-btn">
                            <button id="btnClear" class="btn btn-success" style="border:1px solid #419641;" type="button">សំអាត</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1" style="width:135px; padding-left:0px;">
                    <input type="text" id="fromDate" name="fromDate" class="form-control btn-default" placeholder="ថ្ងៃខែឆ្នាំលក់">
                </div>
                <div class="col-sm-1" style="width:25px;margin-top:5px; padding-left:0;">ដល់</div>
                <div class="col-sm-1" style="width:135px;">
                    <input type="text" id="toDate" name="toDate" class="form-control btn-default" placeholder="ថ្ងៃខែឆ្នាំលក់">
                </div>
                <div class="col-sm-1" style="width:220px; padding-left:0;">
                    <button type="submit" id="btnsearch" class="btn btn-success"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="hdfSupplyId" name="hdfSupplyId" value="">
</form>
<div class="row">

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
<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
<script type="text/javascript">
(function(){
    $('.list-group-item:eq(15)').addClass('active');


    var dateFrom = moment().format('YYYY-MM-1');
    var dateTo   = moment().format('YYYY-MM-DD');

    $('#fromDate').val(dateFrom);
    $('#toDate').val(dateTo);

    $('#fromDate').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: moment()
    });

    $('#toDate').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: moment()
    });

    $("#fromDate").on("dp.change", function (e) {
        $('#toDate').data("DateTimePicker").minDate(e.date);
    });
    $("#toDate").on("dp.change", function (e) {
        $('#fromDate').data("DateTimePicker").maxDate(e.date);
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

    //Function On selected supplier name
    $('body').on('click','.selected',function(){
        var supplyName = $(this).attr('data-name');
        var supplyId = $(this).attr('data-id');
        $('#supplyName').val(supplyName);
        $('#hdfSupplyId').val(supplyId);
        $('#myModal').modal('hide');
    });

    //Function click on button reset
    $('body').on('click', '#btnClear', function () {
        $('#hdfSupplyId').val('');
        $('#supplyName').val('');
    });

})();
</script>
<script src="{{url('/script/report/report.js')}}" charset="utf-8"></script>
@endsection
