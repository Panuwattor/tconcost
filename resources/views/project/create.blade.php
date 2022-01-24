@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">โครงการ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">โครงการ</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">รายการโครงการ</h3>
                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <form id="form_submit" action="/project" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group" hidden>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="customRadio_type1" value="0" name="type" checked="">
                                                <label for="customRadio_type1" class="custom-control-label">โครงการทั่วไป</label>
                                            </div>
                                        </div>
                                        <!-- <div class="col-6">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="customRadio_type2" value="1" name="type">
                                                <label for="customRadio_type2" class="custom-control-label">โครงการภายใน</label>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span for="inputEmail3">ชื่อโครงการ <span class="text-danger">*</span></span>
                                    <div>
                                        <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span for="inputEmail3">รหัสโครงการ <span class="text-danger">*</span></span>
                                    <div>
                                        <input required type="text" class="form-control" id="code" value="{{$code}}" name="code" placeholder="Code">
                                    </div>
                                </div>
                                <div class="form-group" hidden>
                                    <span for="inputEmail3">สาขา <span class="text-danger">*</span></span>
                                    <div>
                                        <select required name="branch_id" class="form-control select2" id="">
                                            @foreach($branchs as $branch)
                                            <option value="{{$branch->id}}">{{$branch->code}} {{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="card direct-chat direct-chat-primary collapsed-card">
                                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                                        <div class="form-group">
                                            <span for="inputEmail3">ชื่อลูกค้า  </span>
                                            <div class="input-group">
                                                <select name="new_customer_id" class="form-control select2" id="">
                                                    <option value="">เลือก</option>
                                                    @foreach($customers as $customer)
                                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-append">
                                                    <button type="button"  data-card-widget="collapse" class="btn btn-info btn-flat">สร้างใหม่</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" style="display: none;">
                                        <div class="direct-chat-messages">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <span for="inputEmail3">ชื่อ</span>
                                                        <div>
                                                            <input type="text" class="form-control" id="inputEmail3" name="customer_name" placeholder="ชื่อ">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <span for="inputEmail3">โทร</span>
                                                        <div>
                                                            <input type="text" class="form-control" id="inputEmail3" name="customer_tel" placeholder="โทรศัพท์">
                                                        </div>
                                                    </div>
                                                    <div class="form-group" hidden>
                                                        <span for="inputEmail3">โทรสาร</span>
                                                        <div>
                                                            <input type="text" class="form-control" id="inputEmail3" name="customer_fax" placeholder="โทรสาร">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <span for="inputEmail3">เลขประจำตัวผู้เสียภาษี</span>
                                                        <div>
                                                            <input type="text" class="form-control" id="inputEmail3" name="customer_txt_tin" placeholder="เลขประจำตัวผู้เสียภาษี">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group" hidden>
                                                        <span for="inputEmail3">สถานะ</span>
                                                        <div>
                                                            <select class="form-control" name="customer_status" id="status">
                                                                <option value="customer">customer</option>
                                                                <option value="supplier">supplier</option>
                                                                <option value="customer , supplier">customer , supplier</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" hidden>
                                                        <span for="inputEmail3">อีเมลล์</span>
                                                        <div>
                                                            <input type="text" class="form-control" id="inputEmail3" name="customer_email" placeholder="อีเมลล์">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <span for="inputEmail3">ที่อยู่</span>
                                                        <div>
                                                            <textarea class="form-control" rows="2" name="customer_address" placeholder="Enter ..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <span for="inputEmail3">note</span>
                                                        <div>
                                                            <textarea class="form-control" rows="2" name="customer_note" placeholder="Enter ..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span for="inputEmail3">ประเภทโครงการ <span class="text-danger">*</span></span>
                                    <div>
                                        <select required name="project_type_id" class="form-control select2" id="">
                                            @foreach($project_types as $project_type)
                                            <option value="{{$project_type->id}}">{{$project_type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span required for="inputEmail3">มูลค่าสัญญา (ไม่รวม VAT) <span class="text-danger">*</span></span>
                                    <div>
                                        <input required type="text" class="form-control" id="project_cost" name="project_cost_new" placeholder="มูลค่าสัญญา" step="1.0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span for="inputEmail3">VAT</span>
                                    <div>
                                        <input type="number" class="form-control" id="vat2" name="vat" placeholder="VAT" value="7" step="any">
                                    </div>
                                    <div class="form-group clearfix mt-2" onclick="check_vat()">
                                        <div class="custom-control custom-radio d-inline">
                                            <input class="custom-control-input" type="radio" id="customRadio1" value="ใน" name="vat_type" checked="">
                                            <label for="customRadio1" class="custom-control-label">Vat ใน</label>
                                        </div>
                                        <div class="custom-control custom-radio d-inline">
                                            <input class="custom-control-input" type="radio" id="customRadio2" value="นอก" name="vat_type">
                                            <label for="customRadio2" class="custom-control-label">Vat นอก</label>
                                        </div>
                                        <div class="custom-control custom-radio d-inline">
                                            <input class="custom-control-input" type="radio" id="customRadio3" value="ไม่มี" name="vat_type">
                                            <label for="customRadio3" class="custom-control-label">ไม่มี Vat</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <span for="inputEmail3">ผู้รับผิดชอบโครงการ <span class="text-danger">*</span></span>
                                    <div>
                                        <select required name="main_user_id" class="form-control select2" id="">
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}" @if($user->id == auth()->user()->id) selected @endif>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span for="inputEmail3">สถานที่ก่อสร้าง <span class="text-danger">*</span></span>
                                    <div>
                                        <textarea required class="form-control" rows="3" name="address" placeholder="Enter ..."></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <span for="inputEmail3">วันที่เริ่มต้น <span class="text-danger">*</span></span>
                                        <div>
                                            <input required autocomplete="off" type="date" name="start_date" class="form-control datepicker" id="datepicker" value="{{Carbon\Carbon::today()->format('Y-m-d')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <span for="inputEmail3">วันที่สิ้นสุด <span class="text-danger">*</span></span>
                                        <div>
                                            <input required autocomplete="off" type="date" name="finish_date" class="form-control datepicker" id="finish_datepicker" value="{{Carbon\Carbon::today()->format('Y-m-d')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span for="inputEmail3">รายละเอียด</span>
                                    <div>
                                        <textarea class="form-control" rows="3" name="note" placeholder="Enter ..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer justify-content-between">
                            <button id="btn_submit" type="submit" class="btn btn-block btn-outline-success btn-lg">บันทึก สร้างโครงการ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('header')
<!-- Select2 -->
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 30px;
    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 38px !important;
        padding-top: 8px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection

@section('footer')
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Select2 -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({
        })

    })
    $(function() {
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });

    function check_vat() {
        if (document.getElementById('customRadio1').checked) {
            document.getElementById('vat2').value = 7;
        } else if (document.getElementById('customRadio2').checked) {
            document.getElementById('vat2').value = 7;
        } else if (document.getElementById('customRadio3').checked) {
            document.getElementById('vat2').value = 0;
        }
    }

    "use strict";

    function NumericInput(inp, locale) {
        var numericKeys = '0123456789';

        // restricts input to numeric keys 0-9
        inp.addEventListener('keypress', function(e) {
            var event = e || window.event;
            var target = event.target;

            if (event.charCode == 0) {
                return;
            }

            if (-1 == numericKeys.indexOf(event.key)) {
                // Could notify the user that 0-9 is only acceptable input.
                event.preventDefault();
                return;
            }
        });

        // add the thousands separator when the user blurs
        inp.addEventListener('blur', function(e) {
            var event = e || window.event;
            var target = event.target;

            var tmp = target.value.replace(/,/g, '');
            var val = Number(tmp).toLocaleString(locale);

            if (tmp == '') {
                target.value = '';
            } else {
                target.value = val;
            }
        });

        // strip the thousands separator when the user puts the input in focus.
        inp.addEventListener('focus', function(e) {
            var event = e || window.event;
            var target = event.target;
            var val = target.value.replace(/[,.]/g, '');

            target.value = val;
        });
    }

    var textDe = new NumericInput(document.getElementById('project_cost', 'de-DE'));
</script>

@endsection