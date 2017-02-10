@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
    <i class="fa fa-plus-square" aria-hidden="true"></i> កែប្រែអ្នកសួរព័ត៍មាន
</div>
<form id="formInfoEdit" class="form-horizontal" method="POST" onsubmit="return false;">
    {{ csrf_field() }}
    <input type="hidden" id="customerAskId" name="customerAskId" value="{{$customerask->Id}}">
    <input type="hidden" id="CustomerId" name="CustomerId" value="{{$customer->Id}}">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ឈ្មោះអតិជិជន</label>
                <div class="col-sm-1" style="width:300px;">
                    <input type="text" class="form-control btn-default" readonly  value="{{$customer->CustomerName}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">អស័យដ្ឋាន</label>
                <div class="col-sm-1" style="width:560px;">
                <input type="text" class="form-control btn-default" readonly  value="{{$customer->Address}}">
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ថ្ងៃសួរ</label>
                <div class="col-sm-1" style="width:220px;">
                    <input type="text" id="askdate" name="AskDate" value="{{$customerask->AskDate}}" class="form-control btn-default">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">ថ្ងៃបញ្ជាក់</label>
                <div class="col-sm-1" style="width:220px;">
                    <input type="text" id="confirmdate" name="ConfirmDate" value="{{$customerask->ConfirmDate}}" class="form-control btn-default">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">បរិយាយ</label>
                <div class="col-sm-1" style="width:560px;">
                    <input type="text" name="Description" value="{{$customerask->Description}}" class="form-control">
                </div>
            </div>
            <div id="info-reason" class="form-group" style="display:none;">
                <label class="col-sm-1 control-label" style="width:150px;">ហេតុផល</label>
                <div class="col-sm-1" style="width:560px;">
                    <input type="text" id="Reason" name="Reason" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;">កំណត់ចំណាំ</label>
                <div class="col-sm-2">
                    <select class="form-control btn-default" id="StatusId" name="StatusId" style="font-size:10pt;padding:3px;">
                        <option value="1">រង់ចាំ</option>
                        <option value="2">បោះបង់</option>
                        <option value="3">ជោគជ័យ</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:150px;"></label>
                <div class="col-sm-1" style="width:300px;">
                    <button type="submit" id="save" class="btn btn-success">រក្សាទុក</button>
                    <a href="{{url('/view/askinfo')}}" class="btn btn-danger">បោះបង់</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
<script type="text/javascript">
    $('.list-group-item:eq(2)').addClass('active');
</script>
<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
<script src="{{url('/script/customers/info.update.js')}}" charset="utf-8"></script>
@endsection
