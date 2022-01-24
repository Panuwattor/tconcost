@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">invoice</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/invoice-ap">invoice list</a></li>
                    <li class="breadcrumb-item active">invoice</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">invoice</h3>
    </div>
    <div class="card-body table-responsive" id="app" v-cloak>
        <form action="/invoice-ap/create" method="post" onsubmit="return confirm('ยืนยันสร้าง invoice ท่านได้ตรวจสอบแล้วว่าข้อมูลถูกต้อง ?')">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>โครงการ</label>
                                <input type="text" class="form-control form-control-sm" readonly value="{{$project->name}}">
                                <input type="hidden" name="project_id" class="form-control form-control-sm" value="{{$project->id}}">
                            </div>
                            <div class="form-group">
                                <label>ผู้ขาย</label>
                                <input type="text" class="form-control form-control-sm" readonly value="{{$supplier->name}}">
                                <input type="hidden" name="supplier_id" class="form-control form-control-sm" value="{{$supplier->id}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>วันที่</label>
                                <input required value="{{\Carbon\Carbon::today()->format('Y-m-d')}}" autocomplete="off" type="text" name="date" class="form-control form-control-sm" id="datepicker">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <!-- <div class="row">
                        <div class="col-12 col-md-4"></div>
                        <div class="col-12 col-md-8">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="border-top: 0px solid #dee2e6" colspan="2">Reference</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            TAX INVOICE NO.
                                            <input class="form-control form-control-sm" type="text" name="tax_invoice_no">
                                        </td>
                                        <td>
                                            DATE
                                            <input autocomplete="off" class="form-control form-control-sm" type="text" name="tax_invoice_date" id="tax_invoice_date">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            INVOICE.
                                            <input class="form-control form-control-sm" type="text" name="invoice">
                                        </td>
                                        <td>
                                            DATE
                                            <input autocomplete="off" class="form-control form-control-sm" type="text" name="invoice_date" id="invoice_date">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
                </div>
            </div>
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr class="text-center">
                        <th>Code</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Accounting</th>
                        <th>Unit Price</th>
                        <th>Unit Discount</th>
                        <th>Special Discount</th>
                        <th>Invoice Discount</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(receive, receive_index) in receives">
                        <template>
                            <input type="hidden" name="receives_id[]" :value="receive.id">
                        </template>
                        <tr class="text-center" v-for="(receive_list, receive_list_index) in receive.receive_lists">
                            <td>
                                <input type="hidden" name="receives_list_id[]" :value="receive_list.id">
                                @{{receive.code}}
                            </td>
                            <td>@{{receive_list.name}}</td>
                            <td>@{{numer(receive_list.amount)}}</td>
                            <td>@{{receive_list.unit}}</td>
                            <td style="width: 20%;">
                                <select required name="receive_account_id[]" :id="'receive_account_id' + receive_list_index" :class="'form-control form-control-ms m_select' + receive_list_index">
                                    <option value="">เลือก</option>
                                    <template v-for="(account, account_index) in all_accounts">
                                        <option :value="account.id">@{{account.code}}: @{{account.name}}</option>
                                        <!-- <option :value="account.id" v-if="receive.type == 'RR' && account.code == '510001'" selected>@{{account.code}}: @{{account.name}}</option>
                                        <option :value="account.id" v-if="receive.type == 'PAD' && account.code == '510003'" selected>@{{account.code}}: @{{account.name}}</option>
                                        <option :value="account.id" v-if="receive.type == 'RS' && account.code == '510001'" selected>@{{account.code}}: @{{account.name}}</option>
                                        <option :value="account.id" v-else>@{{account.code}}: @{{account.name}}</option> -->
                                    </template>
                                </select>
                            </td>
                            <td>@{{numer(receive_list.unit_price)}}</td>
                            <td>@{{numer(receive_list.unit_discount)}}</td>
                            <td>@{{numer(receive_list.special_discount)}}</td>
                            <td>
                                <input type="number" step="any" class="form-control form-control-sm" name="receive_list_invoice_discount[]" v-model="receive_list.invoice_discount" @change="cal">
                            </td>
                            <td class="text-right" v-if="receive_list.invoice_discount">@{{numer(receive_list.price - receive_list.invoice_discount)}}</td>
                            <td class="text-right" v-else>@{{numer(receive_list.price)}}</td>
                        </tr>
                    </template>
                    
                </tbody>
            </table>
            <div class="row">
                <div class="col-7">
                    <div class="form-group">
                        <span>หมายเหตุ : </span>
                        <textarea style="width: 60%;" name="note" class="form-control form-control-sm" cols="30" rows="3"></textarea>
                    </div>

                    @if($supplier->deposits->where('vat_type', $vat_type)->count() > 0 && $supplier->deposits->where('vat_type', $vat_type)->sum('remian') > 0)
                    <select id="deposit_id" style="width: 40%;" class="form-control select2">
                        @foreach($supplier->deposits->where('vat_type', $vat_type) as $deposit)
                        @if($deposit->remian > 0)
                            <option value="{{$deposit->id}}">{{$deposit->code}}</option>
                        @endif
                        @endforeach
                    </select>
                    <span class="text-info" style="cursor: pointer;" @click="add"><i class="fa fa-plus"></i> Add deposit</span>
                    <br>

                    <div class="row" v-for="(ap, index) in deposits">
                        <div class="col-3">
                            <div class="form-group">
                                <input name="deposit_id[]" readonly type="hidden" v-model="ap.id" class="form-control form-control-sm">
                                <input name="" readonly type="text" v-model="ap.code" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <input readonly type="text" v-model="ap.amount" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <input readonly type="text" v-model="ap.remian" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <input name="deposit_use[]" v-model="ap.useage" required type="number" class="form-control form-control-sm" placeholder="จ่าย"  min="1" v-bind:max="ap.remian" step=".01" @change="cal()">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <span class="text-danger" style="cursor: pointer;"><i class="fas fa-trash-alt" @click="remove_de(index)"></i> ลบ</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <b><span class="text-info">Total : @{{numer(deposit_sum)}} THB.</span></b>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-5">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">SPECIAL DISCOUNT</label>
                        <div class="col-sm-8">
                            <input readonly type="text" v-model="special_discount" name="special_discount" id="special_discount" class="form-control" placeholder="special discount">
                        </div>
                    </div>
                    <?php
                        $_retention = 0;
                    ?>
                    @foreach($receives as $receive)
                    @if($receive->retention)
                    <?php
                        $_retention = $receive->retention->price;
                    ?>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Retention</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="retention_id" id="retention_id" class="form-control" value="{{$receive->retention->id}}">
                            <input type="text" v-model="retention" name="retention" id="retention" class="form-control" placeholder="retention" value="{{$receive->retention->price}}">
                        </div>
                    </div>
                    @endif
                    @endforeach
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">TOTAL</label>
                        <div class="col-sm-8">
                            <input readonly type="text" v-model="total_price" name="amount" id="total_price" class="form-control" placeholder="รวมเป็นเงิน">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">TAX BASE</label>
                        <div class="col-sm-8">
                            <input readonly type="text" v-model="sum_price" name="tax_base" id="sum_price" class="form-control" placeholder="จำนวนเงิน">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">
                            <label>VAT</label>
                            <select name="vat_type" v-model="vat_type" @change="cal()" id="vat_type" class="form-control">
                                <option value="">ไม่มี</option>
                                <option value="นอก">นอก</option>
                                <option value="ใน">ใน</option>
                            </select>
                        </label>
                        <div class="col-sm-8">
                            <input readonly type="text" name="vat" v-model="vat_amount" id="vat_amount" class="form-control" placeholder="VAT">
                        </div>
                    </div>
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa fa-money"></i></span>

                        <div class="info-box-content">
                            <h5>GRAN TOTAL</h5>
                            <h5 id="cost">@{{numer(sum)}}</h5>
                            <input type="hidden" name="sum" v-model="sum">
                        </div>
                        <button type="submit" class="btn btn-block btn-outline-success w-auto" style="float: right;">บันทึก</button>
                    </div>
                </div>
            </div>
        </form>
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
        height: 30px !important;
        padding-top: 5px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>

<style>
    [v-cloak]>* {
        display: none;
    }

    [v-cloak]::before {
        content: " ";
        display: block;
        position: absolute;
        width: 80px;
        height: 80px;
        background-image: url(http://pluspng.com/img-png/loader-png-indicator-loader-spinner-icon-512.png);
        background-size: cover;
        left: 50%;
        top: 50%;
    }
</style>
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Select2 -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        })
        $('#tax_invoice_date').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        })
        $('#invoice_date').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        })
    })
</script>

<!-- vue cdn -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                total_price: 0,
                special_discount: 0,
                sum_price: 0,
                vat_amount: 0,
                vat_type: '{{$vat_type}}',
                sum: 0,
                deposits: new Array(),
                retention: '{{$_retention}}',
                deposit_sum: 0,
                special_discount: '{{$receive->special_discount}}',
                receives: {!!$json_receives!!},
                all_accounts: {!!$all_accounts!!},
                amount: 0,
            }
        },
        mounted: async function() {
            for(var i = 0; i < this.receives.length; i++){
                for(var x = 0; x < this.receives[i].receive_lists.length; x++){
                    $('.m_select' + x).select2()
                }
            }

            this.cal();
        },
        methods: {
            cal() {
                this.sum_amount();

                this.total_price = this.amount;
                this.sum_price = this.amount;

                this.total_price = this.total_price - parseFloat(this.special_discount);
                this.sum_price = this.sum_price - parseFloat(this.special_discount);
                this.vat_amount = 0;
                var deposit_useage = 0;
                
                if(this.deposits.length > 0){
                    for(var xx = 0; xx < this.deposits.length; xx++){
                        deposit_useage = (parseFloat(deposit_useage) + parseFloat(this.deposits[xx].useage)).toFixed(2);
                    }   
                }   

                if (this.vat_type == "นอก") {
                    this.vat_amount = (this.sum_price * 0.07).toFixed(2);
                } else if (this.vat_type == "ใน") {
                    this.vat_amount = (this.sum_price - this.sum_price / 1.07).toFixed(2);
                    this.sum_price = (this.sum_price / 1.07).toFixed(2);
                }

                this.sum = parseFloat(this.sum_price) + parseFloat(this.vat_amount);
                this.sum = (parseFloat(this.sum) - parseFloat(this.retention)) - parseFloat(deposit_useage);

                this.payments_sum();
            },
            numer(num) {
                return numeral(num).format('0,0.00');
            },
            add: async function() {
                var res = await axios.get('/getDeposit', {params:{
                    deposit_id: document.getElementById('deposit_id').value
                }});

                for(var i = 0; i < this.deposits.length; i++){
                    if(this.deposits[i].id == res.data.id){
                        alert('มีรายการซ้ำกัน');
                        return;
                    }
                }

                this.deposits.push(res.data);
            },
            remove_de(index){
                this.deposits.splice(index, 1);
                this.cal();
            },
            payments_sum(){
                this.deposit_sum = 0;
                for(var i1 = 0; i1<this.deposits.length; i1++){
                    this.deposit_sum = parseFloat(this.deposit_sum) + parseFloat(this.deposits[i1].useage);
                }
            },
            sum_amount(){
                console.log(this.receives)
                this.amount = 0;
                for(var i = 0; i < this.receives.length; i++){
                    for(var x = 0; x < this.receives[i].receive_lists.length; x++){
                        if(this.receives[i].receive_lists[x].invoice_discount){
                            this.amount = (parseFloat(this.amount) + parseFloat(this.receives[i].receive_lists[x].price)) - parseFloat(this.receives[i].receive_lists[x].invoice_discount)
                        }else{
                            this.amount = parseFloat(this.amount) + parseFloat(this.receives[i].receive_lists[x].price)
                        }
                    }
                }
            }
        },
    });
</script>
@endsection