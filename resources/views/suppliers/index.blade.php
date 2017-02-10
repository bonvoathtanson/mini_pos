@extends('layouts.admin')
@section('content')
<div class="box-title">
    <i class="fa fa-list" aria-hidden="true"></i> បញ្ចីរាយនាមអ្នកផ្គត់ផ្គង់
</div>
<div class="row memu-bar">
    <div class="col-sm-12">
        <div class="pull-right">
            <a href="{{url('/create/supplier')}}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> បន្ថែម</a>
        </div>
    </div>
</div>
<form id="formSupply" method="post" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="panel panel-default" style="width:100%;padding:5px">
        <div class="panel-body">
            <div class="form-group">
                <div class="col-xm-1" style="width:350px; padding-left:0px;">
                    <div class="input-group">
                        <input type="text" id="inputsearch" name="inputsearch" class="form-control btn-default" placeholder="ស្វែករកតាម លេខកូដ ឈ្មោះ លេខទូស័ព្ទ">
                        <span class="input-group-btn">
                            <button id="btnsearch" class="btn btn-success" style="border:1px solid #419641;" type="button">ស្វែងរក</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-sm-12">
        <table id="supplierTable" class="table table-bordered table-hover">
            <thead>
                <tr class="bg-white">
                    <th>លេខកូដ</th>
                    <th>ឈ្មោះអ្នកផ្គត់ផ្គង់</th>
                    <th>ភេទ</th>
                    <th>លេខទូរស័ព្ទ</th>
                    <th>អស័យដ្ឋាន</th>
                    <th class="center" style="width:80px;"></th>
                </tr>
            </thead>
            <tbody></tbody>

        </table>
    </div>
    <div class="box-null" style="font-size:14pt; color:red; padding-left:15px; display:none;">
        ទិន្នន័យស្វែងរកមិនមាន
    </div>
</div>
@endsection
@section('script')
<script src="{{url('/script/suppliers/supplier.index.js')}}" charset="utf-8"></script>
@endsection
