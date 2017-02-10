@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/icheck/iCheck.css')}}" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
  <i class="fa fa-plus-square" aria-hidden="true"></i> កំណត់ត្រាចំណូល
</div>
<form id="formIncome" class="form-horizontal" method="POST" onsubmit="return false;">
    {{ csrf_field() }}
    <input type="hidden" name="CustomerId" value="">
    <input type="hidden" name="IncomeType" value="1">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ឈ្មោះអតិជិជន</label>
                <div class="col-sm-1" style="width:300px;">
                    <input id="customername" type="text" class="form-control btn-default" >
                </div>
                <div class="col-sm-1" style="width:280px; padding-left:0;">
                    <a href="javascript:void(0)" class="btn btn-success customer">ជ្រើសរើសអតិថិជន</a>
                    <a href="{{url('/create/customer')}}" class="btn btn-primary">បន្ថែមអតិថិជនថ្មី</a>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">អាស័យដ្ឋាន</label>
                <div class="col-sm-1" style="width:560px;">
                    <input type="text" id="address" class="form-control btn-default" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ចំណូលក្នុងថ្ងៃ</label>
                <div class="col-sm-1" style="width:200px;">
                    <input type="text" class="form-control btn-default" id="incomedate" name="IncomeDate">
                </div>
            </div>
        </div>
    </div>

    <div class="tableSale">
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="bg-white">
                    <th class="center"></th>
                    <th>មុខទំនិញ</th>
                    <th class="center">កាលបរិច្ឆេទលក់</th>
                    <th class="center">ចំនួន</th>
                    <th class="center">តំលៃលក់</th>
                    <th class="center">ចំនួនទឹកប្រាក់</th>
                    <th class="center">បង់ចំនួន</th>
                    <th class="center">ប្រាក់នៅសល់</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" style="text-align:right;">ចំនួនទឹកប្រាក់សរុប</td>
                    <td style="text-align:right;">
                        <span id="totalamount" style="color:blue; font-weight:bold;">0.00</span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="form-group" style="margin-bottom:50px;">
        <div class="col-sm-12">
            <div class="pull-right">
                <button type="submit" id="save" class="btn btn-success">រក្សាទុក</button>
            </div>
        </div>
    </div>
</form>
<form id="formCustomer" class="form-horizontal" onsubmit="return false;">
    {{ csrf_field() }}
    <div id="SearchModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span id="itemname" style="color:#0856ab; font-weight:bold;">ស្វែងរកឈ្មោះអតិថិជន</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="min-height:350px;">
                    <div style="margin-bottom:3px;">
                        <div class="input-group">
                            <input type="text" name="FilterText" class="form-control btn-default" placeholder="ស្វែករកតាម លេខកូដ ឈ្មោះ លេខទូស័ព្ទ">
                            <span class="input-group-btn">
                                <button class="btn btn-success" id="btnSearch" style="border:1px solid #419641;" type="button">ស្វែងរក</button>
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
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
<script src="{{url('/script/plugin/icheck/icheck.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
<script src="{{url('/script/incomes/income.add.js')}}" charset="utf-8"></script>
<script type="text/javascript">
    (function() {
        SetValidation();
        function SaveOrUpdate() {
            var checkeds = $(':checkbox:checked');
            if(checkeds.length > 0){
                $('body').append(Loading());
                var item = $('#formIncome').serialize();
                $.ajax({
                    type: 'POST',
                    url: burl + '/insert/income',
                    data: item
                }).done(function (data) {
                    if (data.IsError == false) {
                        window.location.reload();
                    } else {
                        swal(data.Message, '', 'success');
                    }
                }).complete(function (data) {
                    $('body').find('.loading').remove();
                });
            }else{
                swal('សូមជ្រើសរើសទំនិញ ដែលត្រូវបង់', '', 'warning');
            }
        }
        function SetValidation() {
            var form = $('body').find('#formIncome');
            form.bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    IncomeDate: {
                        validators: {
                            notEmpty: {
                                message: 'ថ្ងៃខែឆ្មាំ តំរូវអោយបញ្ចូល'
                            },
                            date: {
                                format: 'YYYY-MM-DD',
                                message: 'ទំរង់ថ្ងៃខែឆ្មាំមិនត្រឹមត្រូវ'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function (e) {
                SaveOrUpdate();
            });
        }
    })();
</script>
@endsection
