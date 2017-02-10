@extends('layouts.admin')
@section('content')
<div class="box-title">
    <i class="fa fa-plus-square" aria-hidden="true"></i> បន្ថែមមុខទំនិញថ្មី
</div>
<form id="formItem" class="form-horizontal" action="" method="post" onsubmit="return false;">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="box-form">
        <div class="form-group">
            <label class="col-sm-2 control-label">ឈ្មោះមុខទំនិញ</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="itemname" id="txtname">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">លេខកូដទំនិញ</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="itemcode" id="inputEmail3">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">តំលៃលក់ចេញ</label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="price" id="txtprice" step="any">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">ចំនួនក្នុងស្តុក</label>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="quantity" id="txtqty">
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
<script src="{{url('/script/items/itemed.js')}}" charset="utf-8"></script>
@endsection
