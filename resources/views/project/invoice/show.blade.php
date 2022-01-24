@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">ใบแจ้งหนี้ Invoice</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">ใบแจ้งหนี้ Invoice</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <form action="/invoice-ar/create/store" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card card-default">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fa fa-file-pdf-o mr-1"></i>
                            ใบแจ้งหนี้ Invoice
                        </h3>
                        <div class="card-tools">
                            <a href="/project/invoice/print/{{$invoice->id}}" target="back_"><button type="button" class="btn btn-outline-secondary"><i class="fa fa-print"></i> พิมพ์</button> </a>
                            @if($invoice->status == 0)
                            <a href="/invoice/cancel/{{$invoice->id}}"><button type="button" class="btn btn-outline-danger"><i class="fa fa-times-circle-o"></i> ยกเลิก</button> </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                           <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label>code</label>
                                    <br><span class="text-secondary">{{$invoice->code}}</span>
                                </div>
                            </div>
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
                                    <label>Invoice AR Date</label>
                                    <br><span class="text-secondary">{{$invoice->date}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                            <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>วันที่</th>
                                        <th>ประเภท</th>
                                        <th>รายละเอียด</th>
                                        <th>หน่วย</th>
                                        <th class="text-right">จำนวนเงิน</th>
                                        <th class="text-right">ส่วนลด</th>
                                        <th class="text-right">รวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice->incomes as $key=>$income)
                                    <tr>
                                        <td class="text-center">
                                            {{$key+1}}
                                        </td>
                                        <td class="text-center">{{$income->date}}</td>
                                        <td class="text-center">{{$income->type}}</td>
                                        <td>{{$income->description}} <br><small>{{$income->note}}</small></td>
                                        <td class="text-center">{{$income->unit}}</td>
                                        <td class="text-right">{{ number_format($income->price,2)}}</td>
                                        <td class="text-right">{{ number_format($income->discount,2)}}</td>
                                        <td class="text-right">{{ number_format($income->total,2)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <tr>
                                        <th colspan="6" rowspan=4">{{$invoice->note}}</th>
                                        <th class="text-right">Discount</th>
                                        <th class="text-right">{{number_format($invoice->discount,2)}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Tax Base</th>
                                        <th class="text-right">{{number_format($invoice->tax_base,2)}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">VAT</th>
                                        <th class="text-right">{{number_format($invoice->vat_amount,2)}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">จำนวนเงิน</th>
                                        <th class="text-right">{{number_format($invoice->total,2)}}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-3" id="app">
                            <div class="col-12 col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">ชำระเงิน 
                                        <label class="col-form-label text-success">{{$invoice->payment_condition}}
                                            @if($invoice->payment_condition == 'เครดิต')
                                            {{$invoice->credit_amount}} วัน  ({{$invoice->dateOver}})
                                            @endif
                                        </label>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('header')
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
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

    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 10vw;
    }

    .truncate:before {
        content: attr(data-longstring);
    }

    .truncate:hover::before {
        content: attr(data-longstring);
        width: auto;
        height: auto;
        overflow: initial;
        text-overflow: initial;
        white-space: initial;
        background-color: white;
        display: inline-block;
    }
</style>
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>

<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>

<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Select2 -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/js/select2.full.min.js"></script>

<!-- vue cdn -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({width: '100%'})

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })

    $('#date').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
    })
</script>
@endsection