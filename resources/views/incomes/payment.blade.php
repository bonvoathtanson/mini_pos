@extends('layouts.admin')
@section('content')
<div class="box-title">
  <i class="fa fa-plus-square" aria-hidden="true"></i> កំណត់ត្រាចំណូល
</div>
<form id="formCustomer" class="form-horizontal" method="POST" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:160px;">ប្រភេទចំណូល</label>
                <div class="col-sm-1" style="width:200px;">
                    <select class="form-control" name="IncomeType">
                        <option value="1">ចំណូលកាលក់</option>
                        <option value="1">ចំណូលផ្សេងៗ</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:160px;">អតិថិជន់</label>
                <div class="col-sm-1" style="width:350px;">
                    <input type="text" name="CustomerCode" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:160px;">ចំណូលក្នុងថ្ងៃខែឆ្នាំ</label>
                <div class="col-sm-1" style="width:200px;">
                    <input type="text" name="CustomerCode" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:160px;">កំណត់ត្រាផ្សេងៗ</label>
                <div class="col-sm-1" style="width:400px;">
                    <input type="text" name="CustomerCode" class="form-control">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
