@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
    <i class="fa fa-plus-square" aria-hidden="true"></i> កំណត់ត្រាកាលក់របស់អតិថិជន [{{$customer->CustomerName}}]
</div>
<form id="formSale" class="form-horizontal" onsubmit="return false;">
    {{ csrf_field() }}
    <input type="hidden" name="CustomerId" value="{{$customer->Id}}">
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
                <label class="col-sm-1 control-label" style="width:150px;">អាស័យដ្ឋាន</label>
                <div class="col-sm-1" style="width:560px;">
                    <input type="text" class="form-control btn-default" value="{{$customer->Address}}">
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom:5px;">
        <div class="col-sm-12" style="padding-left:0;">
            <div class="col-sm-1" style="width:200px;">
                <input type="text" id="itemcode" class="form-control btn-default" placeholder="វាយ លេខកូដទំនិញ">
            </div>
            <div class="pull-right">
                <a href="{{url('/create/income').'#'.$customer->Id}}" class="btn btn-danger">បង់លុយ</a>
            </div>
        </div>
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#box-tap1" class="font-M1" aria-controls="home" role="tab" data-toggle="tab">មិនទាន់ដឹកចេញ</a></li>
            <li role="presentation"><a href="#box-tap2" class="font-M1" aria-controls="home" role="tab" data-toggle="tab">មិនទាន់ទូទាត់</a></li>
            <li role="presentation"><a href="#box-tap3" class="font-M1" aria-controls="home" role="tab" data-toggle="tab">ទូទាត់ហើយ</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="box-tap1">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-white">
                            <th class="center">លេខកូដលក់ចេញ</th>
                            <th>មុខទំនិញ</th>
                            <th class="center">កាលបរិច្ឆេទលក់</th>
                            <th class="center">លេខឡាន</th>
                            <th class="center">ចំនួន</th>
                            <th class="center">ត្រូវដឹកចេញ</th>
                            <th style="width:25px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transfers as $key => $value): ?>
                            <tr data-id="{{$value->Id}}">
                                <td class="center">{{$customer->CustomerCode}}-{{$value->SaleCode}}</td>
                                <td>{{$value->Item->ItemName}}</td>
                                <td class="center">{{date_format(date_create($value->SaleDate), 'Y-m-d H:i')}}</td>
                                <td class="center">{{$value->CarNumber}}</td>
                                <td class="center">{{$value->Quantity}}</td>
                                <td class="center">{{date_format(date_create($value->SaleDate), 'Y-m-d ម៉ោង H:i')}}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-e transfer">ដឹកចេញ</button>
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
                            <th class="center">លេខកូដលក់ចេញ</th>
                            <th>មុខទំនិញ</th>
                            <th class="center">កាលបរិច្ឆេទលក់</th>
                            <th class="center">លេខឡាន</th>
                            <th class="center">ចំនួន</th>
                            <th class="center">តំលៃលក់</th>
                            <th style="text-align:right;">ទឹកប្រាក់សរុប</th>
                            <th style="text-align:right;">ទឹកប្រាក់បង់</th>
                            <th style="text-align:right;">ទឹកប្រាក់នៅសល់</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($oncredits as $key => $value): ?>
                            <tr>
                                <td class="center">{{$customer->CustomerCode}}-{{$value->SaleCode}}</td>
                                <td>{{$value->Item->ItemName}}</td>
                                <td class="center">{{date_format(date_create($value->SaleDate), 'Y-m-d H:i')}}</td>
                                <td class="center">{{$value->CarNumber}}</td>
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
                            <th class="center">លេខកូដលក់ចេញ</th>
                            <th>មុខទំនិញ</th>
                            <th>កាលបរិច្ឆេទលក់់</th>
                            <th class="center">លេខឡាន</th>
                            <th class="center">ចំនួន</th>
                            <th class="center">តំលៃលក់</th>
                            <th style="text-align:right;">ចំនួនទឹកប្រាក់</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($onpayoffs as $key => $value): ?>
                            <tr>
                                <td class="center">{{$customer->CustomerCode}}-{{$value->SaleCode}}</td>
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
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="hidden" id="itemid" name="ItemId">
                    <span id="itemname" style="color:#0856ab; font-weight:bold;">ឈ្មោះមុខទំនិញ</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-1 control-label" style="width:150px;">កាលបរិច្ឆេទលក់</label>
                        <div class="col-sm-1" style="width:350px;">
                            <input type="text" id="saledate" name="SaleDate" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" style="width:150px;">ចំនួន</label>
                        <div class="col-sm-1" style="width:150px;">
                            <input type="text" id="quantity" name="Quantity" class="form-control">
                        </div>
                        <div class="col-sm-1" style="width:150px; padding-left:0;">
                             <label class="control-label">ចំនួនក្នុងស្តុក <span id="viewqty" style="color:blue;">0</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" style="width:150px;">តំលៃលក់ចេញ</label>
                        <div class="col-sm-1" style="width:150px;">
                            <input type="text" id="saleprice" name="SalePrice" class="form-control">
                        </div>
                    </div>
                    <div id="group-date" class="form-group">
                        <label class="col-sm-1 control-label" style="width:150px;">កាលបរិច្ឆទដឹកអោយ</label>
                        <div class="col-sm-1" style="width:350px;">
                            <input type="text" id="transferdate" name="TransferDate" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" style="width:150px;">ទឹកប្រាក់សរុប</label>
                        <div class="col-sm-1" style="width:350px;">
                            <input type="text" id="totalamount" name="TotalAmount" class="form-control" disabled="disabled" value="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" style="width:150px;">បង់ប្រាក់ចំនួន</label>
                        <div class="col-sm-1" style="width:350px;">
                            <input type="text" id="payamount" name="PayAmount" class="form-control" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">បិទ</button>
                    <button type="button" class="btn btn-primary" id="save">រក្សាទុក</button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal fade" tabindex="-1" role="dialog" id="transfermodal">
    <form id="formTransfer" onsubmit="return false;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="Id">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title font-M1">កំណត់ត្រាដឹកជូនអតិថិជន</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width:150px; background:#f2f2f2; vertical-align:middle;">លេខឡាន</th>
                                <td>
                                    <div class="form-group" style="margin-bottom:0;">
                                        <select class="form-control btn-default" style="padding:3px" name="CarNumber">
                                            <option value="">ជ្រើសលេខឡាន</option>
                                            <?php foreach ($cars as $key => $value): ?>
                                                <option value="{{$value->CarNo}}">{{$value->CarNo}} ({{$value->Description}})</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width:150px; background:#f2f2f2; vertical-align:middle;">កាលបរិច្ឆេទដឹកចេញ</th>
                                <td>
                                    <div class="form-group" style="margin-bottom:0;">
                                        <input type="text" class="form-control btn-default" name="TransferDate" id="datetransfer">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">បិទ</button>
                    <button type="submit" class="btn btn-primary" id="btnsave">រក្សាទុក</button>
                </div>
            </div>
        </div>
    </form>
</div>

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
<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
<script src="{{url('/script/sales/sale.add.js')}}" charset="utf-8"></script>
@endsection
