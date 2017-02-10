@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
    <i class="fa fa-list" aria-hidden="true"></i> តារាងចំណូល
</div>
<div style="padding:5px 0px; text-align:right;">
    <a href="{{url('/create/income')}}" class="btn btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i> ចំណូលការលក់</a>
    <a href="{{url('/create/otherincome')}}" class="btn btn-primary"><i class="fa fa-credit-card" aria-hidden="true"></i> ចំណូលផ្សេងៗ</a>
     <a href="javascript:void(0)" id="btnPrint" class="btn btn-primary" ><i class="fa fa-print" aria-hidden="true"></i> បោះពុម្ភ</a>
</div>
<div class="panel panel-default">
  <form id="formSearchIncome" method="post" onsubmit="return false;">
      {{ csrf_field() }}
    <div class="panel-body">
        <table class="table-ed">
            <tbody>
                <tr>
                    <td style="width:280px;" colspan="3">
                        <div class="input-group">
                            <input type="text" id="customerName" name="customerName" class="form-control btn-default" placeholder="ជ្រើសរើសអតិថិជន">
                            <span class="input-group-btn">
                                <button class="btn btn-success" id="btnClear" style="border:1px solid #419641;" type="button">សំអាត</button>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:150px;">
                        <div style="position: relative">
                            <input type="text" id="incomeFromDate" name="incomeFromDate" class="form-control btn-default" placeholder="ចាប់ពីថ្ងៃ">
                        </div>
                    </td>
                    <td style="vertical-align:middle;"><span>ដល់</span></td>
                    <td style="width:150px;">
                        <div style="position: relative">
                            <input type="text" id="incomeToDate" name="incomeToDate" class="form-control btn-default" placeholder="ដល់ថ្ងៃ">
                        </div>
                    </td>
                    <td>
                        <button type="button" id="btnsearch" class="btn btn-success">ស្វែងរក</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" id="customerId" name="customerId">
  </form>
</div>
<div class="row">
    <div class="col-sm-12 container-A4">
        <table id="incomeTable" class="table table-bordered table-hover">
            <thead>
                <tr class="bg-white font-M1">
                    <th>កាលបរិច្ឆេទចំណូល</th>
                    <th>អតិថិជន</th>
                    <th class="center">បរិយាយ</th>
                    <th style="text-align:right;">ចំនួនសរុប</th>
                    <th class="center no-print" style="width:40px;"></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;">សរុប</td>
                    <td style="text-align:right;">
                        <span id="totalamount" style="color:blue; font-weight:bold;">0.00</span>
                    </td>
                    <td class="no-print" style="text-align:right;">
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="print-footer">
        </div>
        <div class="box-null" style="font-size:14pt; color:red; display:none;">
            ទិន្នន័យស្វែងរកមិនមាន
        </div>
    </div>
</div>
<form id="formCustomer" class="form-horizontal" onsubmit="return false;">
    {{ csrf_field() }}
    <div id="searchModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
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
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
<script src="{{url('/script/incomes/income.index.js')}}" charset="utf-8"></script>
<script src="{{url('/script/print/print.js')}}" charset="utf-8"></script>
@endsection
