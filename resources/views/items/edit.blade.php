@extends('layouts.admin')
@section('content')
<div class="box-title">
    <i class="fa fa-plus-square" aria-hidden="true"></i> កែប្រែមុខទំនិញ
</div>
<form id="formItem" class="form-horizontal" method="post" onsubmit="return false;">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{$item->Id}}">
    <div class="box-form">
        <div class="form-group">
            <label class="col-sm-2 control-label">ឈ្មោះមុខទំនិញ</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="itemname" value="{{$item->ItemName}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">លេខកូដទំនិញ</label>
            <div class="col-sm-2">
                <input type="text" class="form-control btn-default" name="itemcode" value="{{$item->ItemCode}}" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">តំលៃលក់ចេញ</label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="price" value="{{$item->SalePrice}}" step="any">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">ចំនួនក្នុងស្តុក</label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="quantity" value="{{$item->UnitInStock}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-5">
                <button type="submit" id="save" class="btn btn-success">រក្សាទុក</button>
                <a href="{{url('/view/item')}}" class="btn btn-danger">បោះបង់</a>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
<script src="{{url('/script/items/item.update.js')}}" charset="utf-8"></script>
@endsection
