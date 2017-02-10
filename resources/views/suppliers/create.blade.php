@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{url('/css/plugin/icheck/iCheck.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
  <i class="fa fa-plus-square" aria-hidden="true"></i> បញ្ចូលព័ត៍មានអ្នកផ្គត់ផ្គង់
</div>
<form id="formSupplier" class="form-horizontal" method="POST" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">លេខកូដ</label>
                <div class="col-sm-1" style="width:120px;">
                    <input type="text" name="SupplierCode" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ឈ្មោះ</label>
                <div class="col-sm-1" style="width:300px;">
                    <input type="text" name="SupplierName" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ភេទ</label>
                <div class="col-sm-1" style="width:300px;">
                    <span>ប្រុស <input type="radio" name="Sex" value="1" checked="checked"/></span>
                    <span style="margin-left:15px;">ស្រី <input type="radio" name="Sex" value="2"/></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">លេខទូរស័ព្ទ</label>
                <div class="col-sm-1" style="width:300px;">
                    <input type="text" name="PhoneNumber" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">អស័យដ្ឋាន</label>
                <div class="col-sm-1" style="width:450px;">
                    <input type="text" name="Address" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;"></label>
                <div class="col-sm-1" style="width:300px;">
                    <button type="submit" id="save" class="btn btn-success">រក្សាទុក</button>
                    <a href="{{url('/view/supplier')}}" class="btn btn-danger">បោះបង់</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
<script src="{{url('/script/plugin/icheck/icheck.js')}}" charset="utf-8"></script>
<script src="{{url('/script/suppliers/supplier.add.js')}}" charset="utf-8"></script>
@endsection
