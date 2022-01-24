@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create receipt</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Create receipt</li>
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
                    <h3 class="card-title">Create receipt</h3>
                </div>
                <div class="card-body">
                    <form action="/receipt-ar/store" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label>โครงการ</label>
                                    <br><span class="text-secondary">{{$project->name}}</span>
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
                                    <br><input  class=" form-control" type="date" name="date" id="date" autocomplete="off" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
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
                                    <?php
                                    $_amount = 0;
                                    $_remain = 0;
                                    $_receipt_amount = 0;
                                    $count = 0;
                                    ?>
                                    @foreach($invoice_ars as $invoice_ar)
                                        @foreach($invoice_ar->incomes as $invoice_ar_list)
                                            <input type="hidden" name="invoice_ar[]" value="{{$invoice_ar->id}}">
                                            <input type="hidden" name="interim_payment_list[]" value="{{$invoice_ar_list->id}}">
                                            <?php
                                            $_amount = $_amount + $invoice_ar_list->sum_price_vat;
                                            $_remain = $_remain + $invoice_ar_list->sum_price_vat - $invoice_ar_list->receive_price;
                                            $_receipt_amount = $_receipt_amount + $invoice_ar_list->sum_price_vat;
                                            ?>
                                            <tr class="text-center">
                                                <td>{{$invoice_ar->code}}</td>
                                                <td class="text-left">{{$invoice_ar_list->description}}</td>
                                                <td class="text-right">{{number_format($invoice_ar_list->sum_price_vat, 2)}}</td>
                                                <td class="text-right">
                                                    <input type="number" name="receipt_amount[]" id="receipt_amount{{$count}}" class="form-control form-control-sm text-center" step="any" max="{{$invoice_ar_list->sum_price_vat - $invoice_ar_list->receive_price}}" value="{{$invoice_ar_list->sum_price_vat - $invoice_ar_list->receive_price}}" onchange="cal_remain()">
                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                            ?>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row" id="app">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <br>
                                    <textarea name="note" id="note" cols="30" rows="2" class="form-control" placeholder="Enter..."></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-3"></div>
                            <div class="col-12 col-md-5">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Amount</label>
                                    <div class="col-sm-8">
                                        <input readonly type="text" name="amount" id="amount" class="form-control form-control-sm" value="{{$_amount}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Remain</label>
                                    <div class="col-sm-8">
                                        <input readonly type="text" name="remain" id="remain" class="form-control form-control-sm" value="{{$_remain}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Receipt Amount</label>
                                    <div class="col-sm-8">
                                        <input readonly type="text" name="receipt" id="receipt" class="form-control form-control-sm" value="{{$_receipt_amount}}">
                                    </div>
                                </div>
                                <div class="info-box mb-3">
                                    <button type="submit" class="btn btn-block btn-outline-success" style="float: right;">บันทึก</button>
                                </div>
                            </div>
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
@endsection

@section('footer')

<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Select2 -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({width: '100%'})

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

    var count = '{{$count}}';
    cal_remain();
    function cal_remain() {
        var receipt = 0;
        var remain = '{{$_remain}}';
        for (var i = 0; i < count; i++) {
            receipt = receipt +  parseFloat(document.getElementById('receipt_amount' + i).value)
        }

        document.getElementById('receipt').value = receipt.toFixed(2);
        document.getElementById('remain').value = (remain - receipt).toFixed(2);
    }
</script>
@endsection