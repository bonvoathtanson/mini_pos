@extends('layouts.admin')
@section('content')
<div class="box-title">
    <i class="fa fa-list" aria-hidden="true"></i> តារាងឈ្មោះគណនីអ្្នកប្រើប្រាស់
</div>
<div class="row memu-bar">
    <div class="col-sm-12">
        <div class="pull-right">
            <a href="{{url('/create/user')}}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> បន្ថែម</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <table id="userTable" class="table table-bordered table-condensed table-hover">
            <thead>
                <tr class="bg-white">
                    <th>ឈ្មោះគណនី</th>
                    <th>អុីម៉ែល</th>
                    <th class="center">ថ្ងៃបង្កើត</th>
                    <th class="center" style="width:30px;"></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{url('/script/users/user.index.js')}}" charset="utf-8"></script>
@endsection
