@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Receipt AR</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/project/add-income/new/{{$project->id}}">แผนรายรับ โครงการ</a></li>
                    <li class="breadcrumb-item active">Receipt AR</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card card-default">
                <div class="card-header ui-sortable-handle">
                    <h3 class="card-title">
                        <i class="fa fa-file-text-o"></i>
                        Receipt AR
                    </h3>

                    @if($receipt_ar->status == 1)
                    <div class="card-tools">
                        <a href="/receipt-ar/show/{{$receipt_ar->id}}/print" target="back_"><button type="button" class="btn btn-outline-secondary pull-right"><i class="fa fa-print"></i> พิมพ์</button> </a>
                    </div>
                    @endif
                    @if($receipt_ar->status == 99)
                        <h1 class="text-center text-danger">ยกเลิกแล้ว </h1> 
                    @endif
                    
                </div>
                <div class="card-body">
                    <form action="/receipt-ar/store" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label>โครงการ</label>
                                    <br><span class="text-secondary"><a href="/project/show/{{$project->id}}">{{$project->name}}</a></span>
                                    <input type="hidden" name="project_id" value="{{$project->id}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label>ลูกค้า</label>
                                    <br><span class="text-secondary">{{$project->customer->name}}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label>Date</label>
                                    <br>
                                    <span class="text-secondary">{{$receipt_ar->date}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>Code</th>
                                        <th class="text-left">รายละเอียด</th>
                                        <th class="text-right">Amount</th>
                                        <th class="text-right">Receipt Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($receipt_ar->receipt_ar_list as $receipt_ar_list)
                                    <tr class="text-center">
                                        <td>{{$receipt_ar_list->receipt_ar->code}}</td>
                                        <td class="text-left">{{$receipt_ar_list->income->description}}</td>
                                        <td class="text-right">{{number_format($receipt_ar_list->income->sum_price_vat, 2)}}</td>
                                        <td class="text-right">{{number_format($receipt_ar_list->receipt, 2)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row" id="app">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <br>
                                    <textarea name="note" id="note" cols="30" rows="2" class="form-control" placeholder="Enter...">{{$receipt_ar->note}}</textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            @if($receipt_ar->status == 1)
            <button type="submit" class="btn btn-outline-danger  pull-right" data-toggle="modal" data-target="#modal-cancel"><i class="fa fa-times-circle-o"></i> ยกเลิก</button>
            <div class="modal fade" id="modal-cancel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header  bg-danger">
                            <h4 class="modal-title"><i class="fa fa-file-text-o mr-1"></i> ยกเลิกรายการ Receipt AR</h4>
                        </div>
                        <form action="/receipt-ar/cancel/{{$receipt_ar->id}}" onsubmit="return confirm('คุณแน่ใจที่จะยกเลิกรายการหรือไม่ ?')" method="post">
                            @csrf
                            <div class="modal-body">
                                <code>ถ้าเป็นรายการล่าสุดจะถูกลบ ถ้าไม่เป็น จะถูกยกเลิก</code>
                                <div class="form-group">
                                    <label>หมายเหตุการยกเลิก</label>
                                    <textarea class="form-control" name="note" rows="3" placeholder="ต้องกรอก ..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-danger  pull-right"><i class="fa fa-times-circle-o"></i> ยกเลิก</button>
                            </div>
                        </form>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            @endif
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
        height: 38px !important;
        padding-top: 8px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>

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

    $('#date').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
    })
</script>
@endsection