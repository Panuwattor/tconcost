@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">ใบเสนอราคา </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/sale/quotations">รายการใบเสนอราคา</a></li>
                    <li class="breadcrumb-item active">ใบเสนอราคา</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลใบเสนอราคา {!!$quotation->state!!}</h3>
                    <div class="card-tools">

                    </div>
                    <div class="modal fade" id="modal-add">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">แก้ไขใบเสนอราคา</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <span for="inputEmail3">ชื่อโครงการ : <strong style="color:#0E710A;">{{$quotation->name}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">รหัสโครงการ : <strong style="color:#0E710A;">{{$quotation->code}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">สาขา : <strong style="color:#0E710A;">{{$quotation->branch->name}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">ลูกค้า : <strong style="color:#0E710A;">{{$quotation->customer->name}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">ประเภทโครงการ : <strong style="color:#0E710A;">{{$quotation->project_type ? $quotation->project_type->name : ''}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">มูลค่าสัญญา (ไม่รวม VAT) : <strong style="color:#0E710A;">{{number_format($quotation->project_cost, 2)}}</strong></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <span for="inputEmail3">VAT {{$quotation->vat_type}} : <strong style="color:#0E710A;">{{number_format($quotation->vat, 2)}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">ผู้รับผิดชอบโครงการ : <strong style="color:#0E710A;">{{$quotation->main_user->name}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">ที่อยู่ : <strong style="color:#0E710A;">{{$quotation->address}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">วันที่เริ่มต้น : <strong style="color:#0E710A;">{{$quotation->start_date}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">วันที่สิ้นสุด : <strong style="color:#0E710A;">{{$quotation->finish_date}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">รายละเอียด : <strong style="color:#0E710A;">{{$quotation->note}}</strong></span>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลลูกค้า</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <span for="inputEmail3">ชื่อ : <strong style="color:#0E710A;">{{$quotation->customer->name}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">ที่อยู่ : <strong style="color:#0E710A;">{{$quotation->customer->address}}</strong></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <span for="inputEmail3">โทรศัพท์ : <strong style="color:#0E710A;">{{$quotation->customer->tel}}</strong></span>
                            </div>

                            <div class="form-group">
                                <span for="inputEmail3">note : <strong style="color:#0E710A;">{{$quotation->customer->note}}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($quotation->status !=  0)
        <div class="col-12 col-md-3">
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">จัดการใบเสนอราคา</h3>
              </div>
              <div class="card-body">
                    @if($quotation->status ==  4 && $quotation->project)
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <a href="/project/show/{{$quotation->project_id}}" type="button" class="btn btn-block btn-outline-info btn-lg"> โครงการ :  {{$quotation->project->code}} </a>
                        </div>
                    @else
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                        <a href="/sale/quotation/{{ $quotation->id }}/print" type="button" class="btn btn-block btn-outline-secondary btn-lg"> <i class="fa fa-print"></i> Print </a>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <a href="/sale/quotation/{{ $quotation->id }}/edit" type="button" class="btn btn-block btn-outline-warning btn-lg"> <i class="fa fa-edit"></i> แก้ไข</a>
                        </div>
                        <!-- /.d-flex -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <form id="form_submit" action="/sale/quotation/{{ $quotation->id }}/project" method="post"  style="width: 100%;"  onSubmit="if(!confirm('ยืนยัน สร้างโครงการ หรือ ไม่ ?')){return false;}">
                                @csrf
                                <button type="submit" class="btn btn-block btn-outline-success btn-lg"> <i class="fa fa-file-text"></i> สร้างโครงการ</button>
                            </form>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <form id="form_submit" action="/sale/quotation/{{ $quotation->id }}/cancel" method="post"  style="width: 100%;"  onSubmit="if(!confirm('ยืนยัน การ ยกเลิก หรือ ไม่ ?')){return false;}" >
                                @csrf
                                <button type="submit" class="btn btn-block btn-outline-danger btn-sm"> <i class="fa fa-times-circle"></i> ยกเลิก</button>
                            </form>
                        </div>
                    @endif
              </div>
            </div>
        </div>
        @endif
        <div class="col-md-12">
            <div class="card card-outline">
                <div class="card-header">
                    <h3 class="card-title">แผนรายรับ</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>วันที่</th>
                                    <th>ประเภท</th>
                                    <th>รายละเอียด</th>
                                    <th>หน่วย</th>
                                    <th class="text-right">จำนวนเงิน</th>
                                    <th class="text-right">รวม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quotation->lists as $income)
                                <tr>
                                    <td class="text-center">{{$income->date}}</td>
                                    <td class="text-center">{{$income->type}}</td>
                                    <td class="text-center">{{$income->description}}</td>
                                    <td class="text-center">{{$income->unit}}</td>
                                    <td class="text-right">{{ number_format($income->price,2)}}</td>
                                    <td class="text-right">{{ number_format($income->total,2)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection

@section('header')
<!-- Select2 -->
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 30px;
    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 30px !important;
        padding-top: 4px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>
@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Select2 -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({
            width: '100%'
        })

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>

<script type="text/javascript">
    $(document).ready(function() {
        bsCustomFileInput.init();
    });

    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
    })

    $('#finish_datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
    })

    function check_vat() {
        if (document.getElementById('customRadio1').checked) {
            document.getElementById('vat').value = 7;
        } else if (document.getElementById('customRadio2').checked) {
            document.getElementById('vat').value = 7;
        } else if (document.getElementById('customRadio3').checked) {
            document.getElementById('vat').value = 0;
        }
    }
</script>

@endsection