@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
  <i class="fa fa-plus-square" aria-hidden="true"></i> កំណត់ត្រាចំណាយ
</div>
<form id="formExpanse" class="form-horizontal" method="POST" onsubmit="return false;">
    {{ csrf_field() }}
    <input type="hidden" name="ExpanseType" value="0">
    <input type="hidden" name="CustomerId" value="">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:160px;">កំណត់ត្រាចំណាយ</label>
                <div class="col-sm-1" style="width:400px;">
                    <input type="text" name="Description" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:160px;">កាលបរិច្ឆេទ​</label>
                <div class="col-sm-1" style="width:200px;">
                    <input type="text" id="expansedate" name="ExpanseDate" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label" style="width:160px;">ចំនួនទឹកប្រាក់</label>
                <div class="col-sm-1" style="width:200px;">
                    <input type="text" name="TotalAmount" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" style="width:160px;"></label>
                <div class="col-sm-5">
                    <button type="submit" id="save" class="btn btn-success">រក្សាទុក</button>
                    <a href="{{url('/view/expanse')}}" class="btn btn-danger">បោះបង់</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
<script type="text/javascript">
    (function() {
        $('.list-group-item:eq(8)').addClass('active');
        $('#expansedate').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: new Date()
        });
        SetValidation();
        function SaveOrUpdate() {
            $('body').append(Loading());
            var item = $('#formExpanse').serialize();
            $.ajax({
                type: 'POST',
                url: burl + '/insert/expanse',
                data: item
            }).done(function (data) {
                if (data.IsError == false) {
                    window.location.href = burl + '/view/expanse';
                } else {
                    swal(data.Message, '', 'success');
                }
            }).complete(function (data) {
                $('body').find('.loading').remove();
            });
        }
        function SetValidation() {
            var form = $('body').find('#formExpanse');
            form.bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    ExpanseDate: {
                        validators: {
                            notEmpty: {
                                message: 'ថ្ងៃខែឆ្មាំ តំរូវអោយបញ្ចូល'
                            },
                            date: {
                                format: 'YYYY-MM-DD',
                                message: 'ទំរង់ថ្ងៃខែឆ្មាំមិនត្រឹមត្រូវ'
                            }
                        }
                    },
                    TotalAmount: {
                        validators: {
                            notEmpty: {
                                message: 'ចំនួនទឹកប្រាក់ តំរូវអោយបញ្ចូល'
                            },
                            numeric:{
                                message: 'ចំនួនទឹកប្រាក់បញ្ចូលជាលេខ',
                                decimalSeparator: '.'
                            }
                        }
                    },
                    Description: {
                        validators: {
                            notEmpty: {
                                message: 'កំណត់ត្រាឈ្មោះចំណូល តំរូវអោយបញ្ចូល'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function (e) {
                SaveOrUpdate();
            });
        }
    })();
</script>
@endsection
