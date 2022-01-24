@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Invoice AR</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Invoice AR</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <form action="/invoice-ar/update/{{$invoice->id}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card card-default">
                    <div class="card-body">
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
                                    <label>Invoice AR Date</label>
                                    <br><input readonly class="text-center" type="text" name="date" id="date" autocomplete="off" value="{{$invoice->date}}">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>IS Code</th>
                                        <th>Contract</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Unit</th>
                                        <th class="text-right">Price</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    $deposit = 0;
                                    $discount = 0;
                                    $retention = 0;
                                    ?>
                                    @foreach($inspections as $i => $inspection)
                                    <input type="hidden" name="inspections_id[]" value="{{$inspection->id}}">
                                    @foreach($inspection->inspection_lists as $i => $inspection_list)
                                    <?php
                                    $interim_list = $inspection_list->interim_payment_list;
                                    $total = $total + $interim_list->price;
                                    $deposit = $deposit + $interim_list->deposit;
                                    $discount = $discount + $interim_list->discount;
                                    $retention = $retention + $interim_list->retention;
                                    ?>
                                    <input type="hidden" name="interim_list_id[]" value="{{$interim_list->id}}">
                                    <tr class="text-center">
                                        <td>{{$i + 1}}</td>
                                        <td>{{$inspection->code}}</td>
                                        <td>{{$interim_list->contract}}</td>
                                        <td>{{$interim_list->type}}</td>
                                        <td>{{$interim_list->description}}</td>
                                        <td>{{$interim_list->unit}}</td>
                                        <td class="text-right">{{number_format($interim_list->price, 2)}}</td>
                                        <td>{{$interim_list->remark}}</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <tr>
                                        <th colspan="6" class="text-center">รวม</th>
                                        <th class="text-right">{{number_format($total, 2)}}</th>
                                        <th></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row" id="app">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <br>
                                    <textarea name="note" id="note" cols="30" rows="2" class="form-control" placeholder="Enter...">{{$invoice->note}}</textarea>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">ชำระเงิน</label>
                                    <div class="col-sm-8">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="customRadio1" value="เงินสด" name="payment_condition" @if($invoice->payment_condition == 'เงินสด') checked @endif @click="onselect_payment()">
                                            <label for="customRadio1" class="custom-control-label">เงินสด</label>
                                        </div>

                                        <div class="custom-control custom-radio" style="margin-top: 10px;">
                                            <input class="custom-control-input" type="radio" id="customRadio2" value="เครดิต" name="payment_condition" @if($invoice->payment_condition == 'เครดิต') checked @endif @click="onselect_payment()">
                                            <label for="customRadio2" class="custom-control-label ">เครดิต &nbsp; &nbsp;
                                                <select name="cradit" id="cradit" class="form-control">
                                                    <option value="">เลือก</option>
                                                    <option value="7" @if($invoice->credit_amount == 7) selected @endif>7 วัน</option>
                                                    <option value="15" @if($invoice->credit_amount == 15) selected @endif>15 วัน</option>
                                                    <option value="30" @if($invoice->credit_amount == 30) selected @endif>30 วัน</option>
                                                    <option value="45" @if($invoice->credit_amount == 45) selected @endif>45 วัน</option>
                                                    <option value="60" @if($invoice->credit_amount == 60) selected @endif>60 วัน</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3"></div>
                            <div class="col-12 col-md-5">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Deposit</label>
                                    <div class="col-sm-8">
                                        <input readonly type="text" v-model="deposit" name="deposit" id="deposit" class="form-control form-control-sm" placeholder="Deposit">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Discount</label>
                                    <div class="col-sm-8">
                                        <input readonly type="text" v-model="discount" name="discount" id="discount" class="form-control form-control-sm" placeholder="Discount">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tax Base</label>
                                    <div class="col-sm-8">
                                        <input readonly type="text" v-model="tax_base" name="tax_base" id="tax_base" class="form-control form-control-sm" placeholder="Tax Base">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">
                                        <label>VAT</label> <span>(@{{vat_type}})</span>
                                        <select style="display: none;" name="vat_type" v-model="vat_type" id="vat_type" class="form-control form-control-sm">
                                            <option value="">ไม่มี</option>
                                            <option value="นอก">นอก</option>
                                            <option value="ใน">ใน</option>
                                        </select>
                                    </label>
                                    <div class="col-sm-8">
                                        <input readonly type="text" name="vat_amount" v-model="vat_amount" id="vat_amount" class="form-control form-control-sm" placeholder="VAT">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Retention</label>
                                    <div class="col-sm-8">
                                        <input readonly type="text" v-model="retention" name="retention" id="retention" class="form-control form-control-sm" placeholder="Retention">
                                    </div>
                                </div>
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa fa-money"></i></span>

                                    <div class="info-box-content">
                                        <h5>จำนวนเงิน</h5>
                                        <h5 id="cost">@{{numer(sum)}}</h5>
                                    </div>
                                    <input type="hidden" name="total" v-bind:value="sum">
                                    <button type="submit" class="btn btn-block btn-outline-success w-auto" style="float: right;">บันทึก</button>
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

<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                deposit: '{{$deposit}}',
                discount: '{{$discount}}',
                tax_base: '{{$total - $discount - $deposit}}',
                TAX_BASE: '{{$total - $discount - $deposit}}',
                retention: '{{$retention}}',
                total: '{{$total}}',
                vat_amount: 0,
                vat_type: '{{$vat_type}}',
                sum: 0,
            }
        },
        mounted() {
            this.cal();
        },
        methods: {
            cal() {
                this.vat_amount = 0;
                this.tax_base = this.TAX_BASE;

                if (this.vat_type == "นอก") {
                    this.vat_amount = (this.tax_base * 0.07).toFixed(2);
                } else if (this.vat_type == "ใน") {
                    this.vat_amount = (this.tax_base - this.tax_base / 1.07).toFixed(2);
                    this.tax_base = (this.tax_base / 1.07).toFixed(2);
                }

                this.sum = parseFloat(this.tax_base) + parseFloat(this.vat_amount);
                this.sum = this.sum - this.retention;
            },
            numer(number) {
                return numeral(number).format('0,0.00');
            },
            onselect_payment(){
                var customRadio1 = document.getElementById('customRadio1');
                var customRadio2 = document.getElementById('customRadio2');

                if(customRadio2.checked){
                    document.getElementById('cradit').required = true
                }else{
                    document.getElementById('cradit').required = false
                }
            },
        },
    });
</script>
@endsection