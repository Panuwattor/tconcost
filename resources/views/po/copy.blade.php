@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Purchase Order</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="/po">รายการขอซื้อ</a></li>
                    <li class="breadcrumb-item active">Purchase Order</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<form id="app" v-cloak action="/po/create" method="post" enctype="multipart/form-data" onsubmit="return confirm('ยืนยัน Copy การสั่งซื้อ ข้อมูลขอซื้อถูกต้อง ?')">
    @csrf
    <input type="hidden" name="po_type" value="{{$type}}">
    <input type="hidden" name="id" value="{{$po->id}}">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Purchase Order</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">โครงการ <span class="text-danger"><b>*</b></span></label>
                        <div class="col-sm-8">
                            <select required class="form-control form-control-sm select2" name="project_id" id="project_id" onchange="setAddress()">
                                <option value="">เลือก</option>
                                @foreach($projects as $project)
                                <option value="{{$project->id}}" @if($project->id == $po->project_id) selected @endif>{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"> <a href="/customer/create">ผู้ขาย</a>  <span class="text-danger"><b>*</b></span></label>
                        <div class="col-sm-8">
                            <select required class="form-control form-control-sm select2" name="supplier_id" id="supplier_id">
                                <option value="">เลือก</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}" @if($supplier->id == $po->supplier_id) selected @endif>{{$supplier->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">ผู้ติดต่อ <span class="text-danger"><b>*</b></span></label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <select class="form-control form-control-sm" name="contract_id" id="contract_id">
                                    <option value="">เลือก</option>
                                    <option v-for="contract in contracts" v-bind:value="contract.id">@{{contract.name}}</option>
                                </select>
                                <div style="cursor: pointer;" class="input-group-append" id="getSupplier" @click="getContract()">
                                    <span class="input-group-text">
                                        <i id="i_search" class="fa fa-search"></i>
                                        <i style="display: none;" id="i_search_spin" class="fas fa-spinner fa-pulse"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">วันที่ขอซื้อ <span class="text-danger"><b>*</b></span></label>
                        <div class="col-sm-8">
                            <input required autocomplete="off" type="text" name="po_date" class="form-control form-control-sm" id="po_date" value="{{$po->po_date}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">กำหนดส่งสินค้า <span class="text-danger"><b>*</b></span></label>
                        <div class="col-sm-8">
                            <input required autocomplete="off" type="text" name="due_date" class="form-control form-control-sm" id="due_date" value="{{$po->due_date}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> ข้อมูลที่อยู่จัดส่ง</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">ผู้รับผิดชอบ <span class="text-danger"><b>*</b></span></label>
                        <div class="col-sm-8">
                            <select required class="form-control form-control-sm select2" name="main_user_id" id="main_user_id">
                                <option value="">เลือก</option>
                                @foreach($main_users as $main_user)
                                <option value="{{$main_user->id}}" <?php if($main_user->id == $po->main_user_id){ print('selected'); } ?>>{{$main_user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">ที่อยู่ <span class="text-danger"><b>*</b></span></label>
                        <div class="col-sm-8">
                            <textarea name="address" id="address" class="form-control form-control-sm" cols="30" rows="3">{{$po->address}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">โทรศัพท์ <span class="text-danger"><b>*</b></span></label>
                        <div class="col-sm-8">
                            <input required autocomplete="0ff" type="text" class="form-control form-control-sm" name="tel" value="{{$po->tel}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">รายการสินค้า</h3>
        </div>
        <div class="card-body row">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th style="width: 30%;">รายการ</th>
                            <th>จำนวน</th>
                            <th>หน่วย</th>
                            <th>ราคาต่อหน่วย</th>
                            <th>ส่วนลด/หน่วย</th>
                            <th>ส่วนลด พิเศษ</th>
                            <th>จำนวนเงิน</th>
                            <th>
                                <span class="text-info" style="cursor: pointer;" @click="add()"><i class="fa fa-plus"></i> เพิ่มแถว</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(item, index) in arr">
                            <tr >
                                <td>
                                    @{{index + 1}}
                                    <input type="hidden" name="po_lists_id[]" v-bind:value="item.id">
                                </td>
                                <td>
                                    <input v-model="item.name" required type="text" name="name[]" id="name" class="form-control form-control-sm" autocomplete="0ff" placeholder="รายการ">
                                </td>
                                <td>
                                    <input v-model="item.amount" required type="text" name="amount[]" id="amount" class="form-control form-control-sm" placeholder="จำนวน" @change="cal()">
                                </td>
                                <td>
                                    <input v-model="item.unit" required type="text" name="unit[]" id="unit" class="form-control form-control-sm" placeholder="หน่วย">
                                </td>
                                <td>
                                    <input v-model="item.unit_price" required type="text" name="unit_price[]" id="unit_price" class="form-control form-control-sm" placeholder="ราคาต่อหน่วย" @change="cal()">
                                </td>
                                <td>
                                    <input v-model="item.unit_discount" type="text" name="unit_discount[]" id="unit_discount" class="form-control form-control-sm" placeholder="ส่วนลด/หน่วย" @change="cal()">
                                </td>
                                <td>
                                    <input v-model="item.special_discount" type="text" name="list_special_discount[]" id="special_discount" class="form-control form-control-sm" placeholder="ส่วนลด/หน่วย" @change="cal()">
                                </td>
                                <td>
                                    <input v-model="item.price" readonly required type="text" name="price[]" id="price" class="form-control form-control-sm" placeholder="ราคา">
                                </td>
                                <td>
                                    <span @click="remove(index)" style="cursor: pointer;" v-if="arr.length > 1" class="text-danger"><i class="fa fa-trash-o"></i> ลบ</span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="col-12 col-md-6">
                <br>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div v-for="(file, file_index) in files">
                            <a  v-bind:href="'https://mytcg.sgp1.digitaloceanspaces.com/' + file.file"><span class="badge bg-info text-sm">@{{file.file}}</span></a> <span  @click="delete_file(file.id)" class="text-danger" style="cursor: pointer;"><i class="fa fa-close"></i> ลบ</span>
                        </div>
                    </div>
                </div>
                <div class="form-group row" v-for="(item1, index1) in arr1">
                    <label class="col-sm-2 col-form-label">ไฟล์</label>
                    <div class="col-sm-10">
                        <input v-model="item1.file" type="file" id="myfile" name="pofile[]">
                        <span class="text-info" @click="add1()" style="cursor: pointer;"><i class="fa fa-plus"></i> เพิ่มแถวใหม่</span>
                        <span @click="remove1(index1)" v-if="arr1.length > 1 && arr1.length -1 == index1" style="cursor: pointer;" class="text-danger"><i class="fa fa-trash-o"></i> ลบ</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ชำระเงิน</label>
                    <div class="col-sm-10">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio1" value="เงินสด" name="payment_type" <?php if($po->payment_type == 'เงินสด'){ print('checked'); } ?> @click="onselect_payment()">
                            <label for="customRadio1" class="custom-control-label">เงินสด</label>
                        </div>

                        <div class="custom-control custom-radio" style="margin-top: 10px;">
                            <input class="custom-control-input" type="radio" id="customRadio2" value="เครดิต" name="payment_type" <?php if($po->payment_type == 'เครดิต'){ print('checked'); } ?> @click="onselect_payment()">
                            <label for="customRadio2" class="custom-control-label ">เครดิต &nbsp; &nbsp;
                                <select name="cradit" id="cradit" class="form-control form-control-sm">
                                    <option value="">เลือก</option>
                                    <option value="7" <?php if($po->cradit == 7){ print('selected'); } ?>>7 วัน</option>
                                    <option value="15" <?php if($po->cradit == 15){ print('selected'); } ?>>15 วัน</option>
                                    <option value="30" <?php if($po->cradit == 30){ print('selected'); } ?>>30 วัน</option>
                                    <option value="45" <?php if($po->cradit == 45){ print('selected'); } ?>>45 วัน</option>
                                    <option value="60" <?php if($po->cradit == 60){ print('selected'); } ?>>60 วัน</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">เงื่อนไขการชำระ</label>
                    <div class="col-sm-10">
                        <textarea name="patment_condition" id="patment_condition" class="form-control form-control-sm" cols="30" rows="3">{{$po->patment_condition}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">หมายเหตุ</label>
                    <div class="col-sm-10">
                        <textarea name="note" id="note" class="form-control form-control-sm" cols="30" rows="3">{{$po->note}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-2"></div>
            <div class="col-12 col-md-4">
                <br>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">SPECIAL DISCOUNT</label>
                    <div class="col-sm-8">
                        <input type="text" v-model="special_discount" name="special_discount" id="special_discount" class="form-control form-control-sm" placeholder="ส่วนลดพิเศษ" @change="cal()">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">TOTAL</label>
                    <div class="col-sm-8">
                        <input readonly type="text" v-model="total_price" name="total_price" id="total_price" class="form-control form-control-sm" placeholder="รวมเป็นเงิน">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">TAX BASE</label>
                    <div class="col-sm-8">
                        <input readonly type="text" v-model="sum_price" name="sum_price" id="sum_price" class="form-control form-control-sm" placeholder="จำนวนเงิน">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">
                        <label>VAT</label>
                        <select name="vat_type" v-model="vat_type" @change="cal()" id="vat_type" class="form-control form-control-sm">
                            <option value="">ไม่มี</option>
                            <option value="นอก">นอก</option>
                            <option value="ใน">ใน</option>
                        </select>
                    </label>
                    <div class="col-sm-8">
                        <input readonly type="text" name="vat_amount" v-model="vat_amount" id="vat_amount" class="form-control form-control-sm" placeholder="VAT">
                    </div>
                </div>
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa fa-money"></i></span>

                    <div class="info-box-content">
                        <h5>GRAN TOTAL</h5>
                        <h5 id="cost">@{{sum}}</h5>
                    </div>
                    <button type="submit" class="btn btn-block btn-outline-success w-auto" style="float: right;">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</form>
<br><br>
@endsection

@section('header')
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
<!-- Select2 -->
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<!-- bs-custom-file-input -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- vue cdn -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Select2 -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/js/select2.full.min.js"></script>
    <script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2({width: '100%'})

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        })
    })
</script>

<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });

    var projects = {!!$projects!!}

    function setAddress() {
        var id = JSON.parse(document.getElementById('project_id').value)
        for (var i = 0; i < projects.length; i++) {
            if (projects[i].id == id) {
                document.getElementById('address').value = '-';
            }
        }
    }
</script>

<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                arr: {!!$po->purchaseOrderLists!!},
                files: '',
                arr1: new Array(),
                total_price: 0,
                special_discount: '{{$po->special_discount}}',
                sum_price: 0,
                vat_amount: 0,
                vat_type: '{{$po->vat_type}}',
                sum: 0,
                supplier_id: '',
                contracts: '',
            }
        },
        mounted() {
            $('#po_date').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            })
            $('#due_date').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            })

            this.cal();
        },
        created() {
            this.arr1.push({
                file: ''
            });
        },
        methods: {
            add() {
                this.arr.push({
                    name: '',
                    amount: 1,
                    unit: '',
                    unit_price: 0,
                    unit_discount: 0,
                    price: 0,
                    special_discount: 0,
                });
            },
            remove(id) {
                this.arr.splice(id, 1);
                this.cal();
            },
            add1() {
                this.arr1.push({
                    file: ''
                });
            },
            remove1(id) {
                this.arr1.splice(id, 1);
            },
            cal(){
                this.total_price = 0;
                this.sum_price = 0;
                this.vat_amount = 0;

                for(var i = 0; i < this.arr.length; i++){
                    this.arr[i].price = (((parseFloat(this.arr[i].unit_price) * parseFloat(this.arr[i].amount)) - (parseFloat(this.arr[i].unit_discount) * parseFloat(this.arr[i].amount)) - parseFloat(this.arr[i].special_discount))).toFixed(2)
                    
                    this.total_price = parseFloat(this.total_price) + parseFloat(this.arr[i].price);
                    this.sum_price = parseFloat(this.sum_price) + parseFloat(this.arr[i].price);
                }

                this.total_price = this.total_price - this.special_discount;
                this.sum_price = this.sum_price - this.special_discount;
                
                if(this.vat_type == "นอก"){
                    this.vat_amount = (this.sum_price * 0.07).toFixed(2);
                }else if(this.vat_type == "ใน"){
                    this.vat_amount = (this.sum_price - this.sum_price / 1.07).toFixed(2);
                    this.sum_price = (this.sum_price / 1.07).toFixed(2);
                }

                this.sum = parseFloat(this.sum_price) + parseFloat(this.vat_amount);
            },
            onselect_payment(){
                var customRadio1 = document.getElementById('customRadio1');
                var customRadio2 = document.getElementById('customRadio2');

                console.log(customRadio2.checked)
                if(customRadio2.checked){
                    document.getElementById('cradit').required = true
                }else{
                    document.getElementById('cradit').required = false
                }
            },
            getContract: async function(){
                var supplier_id = document.getElementById('supplier_id').value;
                if(!supplier_id){
                    alert('ไม่ได้เลือกผู้ขาย');
                    return;
                }

                document.getElementById('i_search').style.display = 'none'
                document.getElementById('i_search_spin').style.display = 'block'

                var res = await axios.get('/getContract', {params: {supplier_id: supplier_id}});

                document.getElementById('i_search').style.display = 'block'
                document.getElementById('i_search_spin').style.display = 'none'

                this.contracts = res.data;
                console.log(this.contracts)
            },
            delete_file: async function(file_id){
                if(confirm('ต้องการลบ file ใช่หรือไม่ ?')){
                    var res = await axios.post('/delete/po/file', 
                    {
                        file_id: file_id,
                        po_id: '{{$po->id}}',
                    });

                    this.files = res.data;
                }
            },
        },
    });
</script>
@endsection