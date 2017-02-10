@extends('layouts.admin')
@section('content')
<div class="box-title" style="margin-bottom:25px;">
    <i class="fa fa-plus-square" aria-hidden="true"></i> បន្ថែមគណនីអ្្នកប្រើប្រាស់
</div>
<form id="formUser" method="POST" onsubmit="return false;">
    {{ csrf_field() }}
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th style="width:180px; vertical-align:middle;">ឈ្មោះគណនី</th>
            <td>
                <div class="form-group" style="margin-bottom:0; width:250px;">
                    <input type="text" name="Name" class="form-control" placeholder="ឈ្មោះគណនេយ្យ">
                </div>
            </td>
        </tr>
        <tr>
            <th style="vertical-align:middle;">អ៊ីម៉ែល</th>
            <td>
                <div class="form-group" style="margin-bottom:0; width:250px;">
                    <input type="email" name="Email" class="form-control" placeholder="អ៊ីម៉ែល">
                </div>
            </td>
        </tr>
        <tr>
            <th style="vertical-align:middle;">លេខសំងាត់</th>
            <td>
                <div class="form-group" style="margin-bottom:0; width:250px;">
                    <input type="password" name="Password" class="form-control" placeholder="លេខសំងាត់">
                </div>
            </td>
        </tr>
        <tr>
            <th style="vertical-align:middle;">បញ្ចាក់លេខសំងាត់</th>
            <td>
                <div class="form-group" style="margin-bottom:0; width:250px;">
                    <input type="password" name="Verify" class="form-control" placeholder="បញ្ចាក់លេខសំងាត់">
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <div>
        <button id="submit" type="submit" name="button" class="btn btn-success">បង្កើត</button>
        <a href="{{url('/view/user')}}" class="btn btn-danger">បោះបង់</a>
    </div>
</form>
@endsection
@section('script')
<script src="{{url('/script/users/user.add.js')}}" charset="utf-8"></script>
@endsection
