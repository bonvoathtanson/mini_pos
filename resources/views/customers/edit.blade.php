@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{url('/css/plugin/icheck/iCheck.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<?php
    function sel($value, $comvalue)
    {
        if($value == $comvalue){
            echo 'selected="selected"';
        }
    }
    function check($value, $comvalue)
    {
        if($value == $comvalue){
            echo 'checked="checked"';
        }
    }
?>
<div class="box-title">
    <i class="fa fa-plus-square" aria-hidden="true"></i> កែប្រែព័ត៍មានអតិថិជន
</div>
<form id="formCustomer" class="form-horizontal" method="POST" onsubmit="return false;">
    {{ csrf_field() }}
    <input type="hidden" name="Id" value="{{$customer->Id}}">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">លេខកូដ</label>
                <div class="col-sm-1" style="width:120px;">
                    <input type="text" class="form-control btn-default" value="{{$customer->CustomerCode}}" readonly="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ឈ្មោះ</label>
                <div class="col-sm-1" style="width:300px;">
                    <input type="text" name="CustomerName" class="form-control" value="{{$customer->CustomerName}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ភេទ</label>
                <div class="col-sm-1" style="width:300px;">
                    <span>ប្រុស <input type="radio" name="Sex" value="1" checked="checked" {{check($customer->Sex, 1)}}/></span>
                    <span style="margin-left:15px;">ស្រី <input type="radio" name="Sex" value="2" {{check($customer->Sex, 2)}}/></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">លេខទូរស័ព្ទ</label>
                <div class="col-sm-1" style="width:300px;">
                    <input type="text" name="PhoneNumber" class="form-control" value="{{$customer->PhoneNumber}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">អស័យដ្ឋាន</label>
                <div class="col-sm-1" style="width:450px;">
                    <input type="text" name="Address" class="form-control" value="{{$customer->Address}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">កំណត់ចំណាំ</label>
                <div class="col-sm-2">
                    <select class="form-control btn-default" style="padding:3px" name="TypeId" style="font-size:10pt;">
                        <option value="0" {{sel($customer->TypeId, 0)}}></option>
                        <option value="1" {{sel($customer->TypeId, 1)}}>សួរពត៍មាន</option>
                        <option value="2" {{sel($customer->TypeId, 2)}}>បញ្ជាទិញ</option>
                        <option value="3" {{sel($customer->TypeId, 3)}}>បោះបង់</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;"></label>
                <div class="col-sm-1" style="width:300px;">
                    <button type="submit" id="save" class="btn btn-success">រក្សាទុក</button>
                    <a href="{{url('/view/customer')}}" class="btn btn-danger">បោះបង់</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
<script src="{{url('/script/plugin/icheck/icheck.js')}}" charset="utf-8"></script>
<script src="{{url('/script/customers/customer.update.js')}}" charset="utf-8"></script>
@endsection
