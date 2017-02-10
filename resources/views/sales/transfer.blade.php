@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{url('/css/plugin/datetimepicker/bootstrap-datetimepicker.min.css')}}" media="screen" title="no title" charset="utf-8">
@endsection
@section('content')
<div class="box-title">
    <i class="fa fa-list" aria-hidden="true"></i>​​ តារាងទំនិញដែលត្រូវដឹកចេញ
</div>
<div class="row memu-bar">
    <div class="col-sm-12">
        <div class="pull-left">
            <button type="button" class="btn btn-primary" id="btncar">លេខឡាន</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <table id="saleTable" class="table table-bordered table-hover">
            <thead>
                <tr class="bg-white">
                    <th>ឈ្មោះអតិថិជន</th>
                    <th>មុខទំនិញ</th>
                    <th class="center">កាលបរិច្ឆេទលក់់</th>
                    <th class="center">កាលបរិច្ឆេទដឹកចេញ</th>
                    <th class="center">ចំនួន</th>
                    <th style="width:80px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $index => $sale): ?>
                    <tr data-id="{{$sale->Id}}">
                        <td>{{$sale->Customer->CustomerName}}</td>
                        <td>{{$sale->Item->ItemName}}</td>
                        <td class="center">{{$sale->SaleDate}}</td>
                        <td class="center" style="color:#0856ab;">{{date_format(date_create($sale->TransferDate),'Y-m-d ម៉ោង H:i')}}</td>
                        <td class="center">{{$sale->Quantity}}</td>
                        <td class="center">
                            <button type="button" class="btn btn-danger btn-e transfer">ដឹកចេញ</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="transfermodal">
    <form id="formTransfer" onsubmit="return false;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="Id">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title font-M1">កំណត់ត្រាដឹកជូនអតិថិជន</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width:150px; background:#f2f2f2; vertical-align:middle;">លេខឡាន</th>
                                <td>
                                    <div class="form-group" style="margin-bottom:0;">
                                        <select class="form-control btn-default" style="padding:3px" name="CarNumber">
                                            <option value="">ជ្រើសលេខឡាន</option>
                                            <?php foreach ($cars as $key => $value): ?>
                                                <option value="{{$value->CarNo}}">{{$value->CarNo}} ({{$value->Description}})</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width:150px; background:#f2f2f2; vertical-align:middle;">កាលបរិច្ឆេទដឹកចេញ</th>
                                <td>
                                    <div class="form-group" style="margin-bottom:0;">
                                        <input type="text" class="form-control btn-default" name="TransferDate" id="transferdate">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">បិទ</button>
                    <button type="submit" class="btn btn-primary" id="save">រក្សាទុក</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="carmodal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="Id">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title font-M1">តារាងលេខឡាន</h4>
            </div>
            <div class="modal-body">
                <div class="box1">
                    <table id="tblCar" class="table table-bordered">
                        <thead>
                            <tr class="bg-white">
                                <th style="width:150px;">លេខឡាន</th>
                                <th>បរិយាយ</th>
                                <th>សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cars as $key => $value): ?>
                                <tr id="{{$value->Id}}">
                                    <td>{{$value->CarNo}}</td>
                                    <td>{{$value->Description}}</td>
                                    <td class="center">
                                        <a href="javascript:void(0);" data-description="{{$value->Description}}" data-car-name="{{$value->CarNo}}" data-id="{{$value->Id}}" class="btn btn-success btn-e edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <button type="button"  class="btn btn-danger btn-e delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="box2" style="display:none;">
                    <form id="formCar">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width:150px; background:#f2f2f2; vertical-align:middle;">លេខឡាន</th>
                                    <td>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <input type="text" class="form-control" name="CarNo" id="CarNo">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:150px; background:#f2f2f2; vertical-align:middle;">បរិយាយ</th>
                                    <td>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <textarea name="Description" class="form-control" id="Description"></textarea>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" id="CarId" name="CarId"/>
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="btnadd">បន្ថែម</button>
                <button type="button" class="btn btn-danger" style="display:none;" id="btncancel">បោះបង់</button>
                <button type="submit" class="btn btn-primary" style="display:none;" id="btnsave">រក្សាទុក</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{url('/script/plugin/bootstrap/moment-with-locales.js')}}" charset="utf-8"></script>
<script src="{{url('/script/plugin/bootstrap/bootstrap-datetimepicker.js')}}" charset="utf-8"></script>
<script type="text/javascript">
(function(){
    $('.list-group-item:eq(1)').addClass('active');
    SetValidation();
    var select;
    $('body').on('click', '#btnsave', function(){

        var action = '/insert/car';
        if($('#CarId').val() !=''){
            action = '/update/car';
            var id =$('#CarId').val();
            $('#'+ id).remove();
        }
        var car = $('[name="CarNo"]').val();
        var des = $('[name="Description"]').val();
        if(car.length == 0){
            swal('សូមបញ្ចូលលេខឡាន', '' , 'warning');
        }else{
            var item = $('#formCar').serialize();
            $.ajax({
                type: 'POST',
                url: burl + action,
                data: item
            }).done(function (data) {
                if (data.IsError == false) {
                    var tr  = '<tr id="'+ data.Id +'"><td>' + car + '</td><td>' + des + '</td>';
                        tr +='<td class="center"><a href="javascript:void(0);" data-description="' + des + '" data-car-name="' + car + '" data-id="'+ data.Id +'" class="btn btn-success btn-e edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        tr +='<button type="button"  class="btn btn-danger btn-e delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
                        tr +='</td></tr>';
                    var option = '<option value="' + car + '">' + car + ' (' + des + ')</option>';
                    $('.box1 table>tbody').append(tr);
                    $('[name="CarNumber"]').append(option);
                    Reset();
                }else {
                    swal(data.Message, '', 'success');
                }
            });
        }
    });

    $('body').on('click', '#btnadd', function(){
        $('#CarNo').val('');
        $('#Description').val('');
        $('#CarNo').attr('readonly', false);
        $('#CarId').val('');
        $('.box1').hide();
        $('.box2').show();
        $('#btnadd').hide();
        $('#btncancel').show();
        $('#btnsave').show();
    });

    $('body').on('click', '.edit', function(){

        var carNo = $(this).attr('data-car-name');
        var description = $(this).attr('data-description');
        var carId = $(this).attr('data-id');
        $('#CarId').val(carId);
        $('#CarNo').val(carNo);
        $('#Description').val(description);
        $('#CarNo').attr('readonly', true);
        $('.box1').hide();
        $('.box2').show();
        $('#btnadd').hide();
        $('#btncancel').show();
        $('#btnsave').show();
    });

    $('#transferdate').datetimepicker({
        defaultDate: moment()
    });

    $('body').on('click', '#btncar', function(){
        $('#carmodal').modal({
            backdrop: 'static'
        });
    });

    $('body').on('click', '.delete', function () {
        var select = $(this).closest('tr');
        var id = $(select).attr('id');
        swal({
            title: 'លុប',
            text: 'តើអ្នកចង់លុបទិន្នន័យឬ ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'យល់ព្រម',
            cancelButtonText: 'បោះបង់',
            closeOnConfirm: false
        }, function () {
            $('body').append(Loading());
            $.ajax({
                type: 'GET',
                url: burl + '/delete/car/' + id,
                dataType: "JSON",
                contentType: 'application/json; charset=utf-8',
            }).done(function (data) {
                if (data.IsError == false) {
                    swal('ទិន្នន័យត្រូវបានលុបជោគជ័យ', '', 'success');
                    $(select).remove();
                } else {
                    swal(data.Message, '', 'success');
                }
            }).complete(function (data) {
                $('body').find('.loading').remove();
            });
        });
    });

    $('body').on('click', '#btncancel', function(){
        Reset();
    });

    $('#carmodal').on('hidden.bs.modal', function (e) {
        Reset();
    });

    $('body').on('click', '.transfer', function () {
        select = $(this).closest('tr');
        var id = $(select).attr('data-id');
        $('[name="Id"]').val(id);
        $('#transfermodal').modal({
            backdrop:'static'
        });
    });

    $('#transfermodal').on('hidden.bs.modal', function (e) {
        select = '';
        $('[name="Id"]').val('');
        $('[name="CarNumber"][value=""]').prop('selected', true);
        $('#transferdate').data("DateTimePicker").date(moment());
    });

    function Reset(){
        $('.box1').show();
        $('.box2').hide();
        $('#btnadd').show();
        $('#btncancel').hide();
        $('#btnsave').hide();
    }

    function SaveOrUpdate() {
        var id = $('[name="Id"]').val();
        $('body').append(Loading());
        var item = $('#formTransfer').serialize();
        $.ajax({
            type: 'POST',
            url: burl + '/transfer/sale',
            data: item
        }).done(function (data) {
            if (data.IsError == false) {
                $(select).remove();
                $('#transfermodal').modal('hide');
                $('#formTransfer').bootstrapValidator("resetForm", true);
                window.open(burl + '/report/transfer/'+ id +'','_blank');
            } else {
                swal(data.Message, '', 'warning');
            }
        }).complete(function (data) {
            $('body').find('.loading').remove();
        });
    }

    function SetValidation() {
        var form = $('body').find('#formTransfer');
        form.bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                CarNumber: {
                    validators: {
                        notEmpty: {
                            message: 'សូមបញ្ចូលលេខឡាន'
                        }
                    }
                },
                TransferDate: {
                    validators: {
                        notEmpty: {
                            message: 'សូមបញ្ចូលថ្ងៃខែឆ្នាំដឹកចេញ'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            SaveOrUpdate();
        });
        $('body').on('click', '#save', function (e) {
            form.bootstrapValidator('validate');
        });
    }
})();


</script>
@endsection
