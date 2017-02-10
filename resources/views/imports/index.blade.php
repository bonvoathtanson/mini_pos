@extends('layouts.admin')
@section('content')
<div class="box-title">
  <i class="fa fa-list" aria-hidden="true"></i> តារាងការទិញចូល
</div>
<div class="row memu-bar">
  <div class="col-sm-12">
    <div class="pull-right">
      <a href="{{url('/view/selsupplier')}}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> ជ្រើសរើសអ្នកផ្គត់ផ្គង់</a>
      <a href="javascript:void(0)" id="btnPrint"  class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> បោះពុម្ភ</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12 container-A4">
    <table id="importTable" class="table table-bordered table-hover">
      <thead>
        <tr class="bg-white font-M1">
          <th>ឈ្មោះអ្នកផ្គត់ផ្គង់</th>
          <th>មុខទំនិញ</th>
          <th class="center">កាលបរិច្ឆេទនាំចូល</th>
          <th>ចំនួន</th>
          <th>តំលៃលក់</th>
          <th style="text-align:right;">ទឹកប្រាក់សរុប</th>
          <th style="text-align:right;">បង់ចំនួន</th>
          <th style="text-align:right;">នៅសល់</th>
          <th class="center no-print" style="width:30px;"></th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
          <tr>
              <td colspan="5" style="text-align:right;">សរុប</td>
              <td style="text-align:right;">
                  <span id="totalamount" style="color:blue; font-weight:bold;">0.00</span>
              </td>
              <td style="text-align:right; border:none;">
                  <span id="payamount" style="color:blue; font-weight:bold;">0.00</span>
              </td>
              <td style="text-align:right;border-bottom:none;">
                  <span id="remain" style="color:blue; font-weight:bold;">0.00</span>
              </td>
              <td style="text-align:right;" class="no-print">
              </td>
          </tr>
      </tfoot>
    </table>

  </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $('.list-group-item:eq(4)').addClass('active');
</script>
<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/imports/import.index.js')}}" charset="utf-8"></script>
<script src="{{url('/script/print/print.js')}}" charset="utf-8"></script>
@endsection
