@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">รับของ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/receive">รายการรับของ</a></li>
                    <li class="breadcrumb-item active">รับของ</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card" id="app" v-cloak>
    <div class="card-header">
        <h3 class="card-title">รับของ</h3>
    </div>
    <div class="card-body table-responsive">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>โครงการ</label>
                            <input type="text" class="form-control form-control-sm" readonly value="{{$po->project->name}}">
                            <input type="hidden" name="project_id" class="form-control form-control-sm" value="{{$po->project->id}}">
                        </div>
                        <div class="form-group">
                            <label>สาขา</label>
                            <input type="text" class="form-control form-control-sm" readonly value="{{$po->project->branch->name}}">
                            <input type="hidden" name="branch_id" class="form-control form-control-sm" value="{{$po->project->branch->id}}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>ผู้ขาย</label>
                            <select class="form-control form-control-sm" v-model="receive.supplier_id">
                                <option value="เลือก">เลือก</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>วันที่</label>
                            <my-date-picker v-model="receive.date"></my-date-picker>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-md-6">
                <div class="row">
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
                                        PO NO.
                                        <br>{{$po->po_id}}
                                    </td>
                                    <td>
                                        DATE
                                        <br>{{$po->po_date}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        PO AMOUNT.
                                        <br>{{number_format($po->sum_price,2)}}
                                    </td>
                                    <td>
                                        PO REMAIN
                                        <br>
                                        <span>@{{numer(receive.po_remain)}}</span>
                                        <span v-if="numer(receive.po_remain) == 0.00">(0.00%)</span>
                                        <span v-else>(@{{numer(receive.po_remain_percent)}}%)</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <div class="form-group row mb-0" v-for="(item1, index1) in arr1">
                    <label class="col-sm-2 col-form-label">ไฟล์</label>
                    <div class="col-sm-10">
                        <input v-on:change="onFileChange" v-model="item1.file" type="file" id="myfile" name="pofile[]">
                        <!-- <span class="text-info" @click="add1()" style="cursor: pointer;"><i class="fa fa-plus"></i> เพิ่มแถวใหม่</span> -->
                        <!-- <span @click="remove1(index1)" v-if="arr1.length > 1 && arr1.length -1 == index1" style="cursor: pointer;" class="text-danger"><i class="fa fa-trash-o"></i> ลบ</span> -->
                    </div>
                </div>
                <span class="right badge badge-info" v-for="(namefile, ind) in file_names">
                    @{{namefile.name}}
                    <span @click="remove_file(ind)" v-if="file_names.length -1 == ind" style="cursor: pointer; margin-right: 5px;" class="text-danger"><i class="fa fa-close"></i></span>
                    <span v-else style="cursor: pointer; margin-right: 5px;" class="text-danger"></span>
                </span>
            </div>
        </div>
        <div class="form-group">
            <label>แนบ File</label>
            <template v-for="(current_file, current_file_index) in current_files">
                <a target="_bank" :href="'https://mytcg.sgp1.digitaloceanspaces.com/' + current_file.file"><span class="right badge badge-info">ไฟล์ @{{current_file_index + 1}}</span></a>
                <a :href="'/receive/delete/file/' + current_file.id"><i class="fa fa-trash text-danger"></i></a> &nbsp;
            </template>
        </div>
        <table class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <!-- <th>ลำดับ</th> -->
                    <th class="text-left">รายการ</th>
                    <th>จำนวน</th>
                    <th>หน่วย</th>
                    <th>ราคาต่อหน่วย</th>
                    <th>ส่วนลด/หน่วย</th>
                    <th>ส่วนลด พิเศษ</th>
                    <th>จำนวนเงิน</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in po_list" class="text-center">
                    <!-- <td>@{{index + 1}}</td> -->
                    <td class="text-left">@{{item.name}}</td>
                    <td style="width: 10%;">
                        <input type="number" v-model="item.amount" @change="cal_price" class="form-control form-control-sm" step="any">
                    </td>
                    <td>@{{item.unit}}</td>
                    <td>@{{item.unit_price}}</td>
                    <td>@{{item.unit_discount}}</td>
                    <td>
                        <input v-if="item.special_discount == item.receive_special_discount" readonly type="number" v-model="item.special_discount" @change="cal_price" class="form-control form-control-sm" step="any">
                        <input v-else type="number" v-model="item.special_discount" @change="cal_price" class="form-control form-control-sm" step="any">
                    </td>
                    <td style="width: 20%;">
                    <!-- @{{item.price}} -->
                        <input type="number" v-model="item.price" @change="price_change(index)" class="form-control form-control-sm" step="any">
                    </td>
                    <td><i class="fa fa-trash text-danger" @click="remove(index)"></i></td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="row" v-if="type == 'RS'">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>วันที่เริ่มงาน</label>
                            <my-date-picker v-model="duedate.start"></my-date-picker>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>วันที่จบงาน</label>
                            <my-date-picker v-model="duedate.finish"></my-date-picker>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <span>เงื่อนไขการชำระ : </span>
                    <select v-model="receive.payment_condition" style="width: 60%;" class="form-control form-control-sm">
                        <option value="จ่ายทันที">จ่ายทันที</option>
                        <option value="เครดิต">เครดิต</option>
                    </select>
                </div>
                <div class="form-group">
                    <span>หมายเหตุ : </span>
                    <textarea style="width: 60%;" name="note" class="form-control form-control-sm" v-model="receive.note" cols="30" rows="3"></textarea>
                </div>
            </div>
            <div class="col-12 col-md-6 text-right">
                <div class="form-group">
                    <span>SPECIAL DISCOUNT : <span style="text-decoration: underline gray;">@{{numer(price.special_discount)}}</span></span>
                </div>
                @if($type == 'PAD')
                <div class="form-group">
                    <span>RETENTION : <input style="text-align: right;" type="text" value="0" v-model="retention" @change="cal_price"></span>
                </div>
                @endif
                <div class="form-group">
                    <span>TAX BASE : <span style="text-decoration: underline gray;">@{{numer(price.sum_price)}}</span></span>
                </div>
                <div class="form-group">
                    <span>
                        VAT :
                        <span style="text-decoration: underline gray;">
                            @{{numer(price.vat_amount)}}
                        </span>
                    </span>
                </div>
                <div class="form-group">
                    <span>TOTAL : <span style="text-decoration: underline gray;">@{{numer((price.sum - retention))}}</span></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button id="btn_submit" @click="submit()" type="button" class="w-auto btn btn-block btn-outline-success btn-sm float-right">บันทึก</button>
                <button style="display: none;" id="btn_loading" type="button" class="w-auto btn btn-block btn-outline-secondary btn-sm float-right">กำลังโหลด.....</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('header')
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

<script>
    Vue.component('my-date-picker',{
        template: '<input required autocomplete="off" type="text" class="form-control form-control-sm" v-datepicker :value="value" @input="update($event.target.value)">',
        directives: {
            datepicker: {
                inserted (el, binding, vNode) {
                    $(el).datepicker({
                        autoclose: true,
                        format: 'yyyy-mm-dd'
                    }).on('changeDate',function(e){
                        vNode.context.$emit('input', e.format(0))
                    })
                }
            }
        },
        props: ['value'],
        methods: {
            update (v){
                this.$emit('input', v)
            }
        }
    })

    var app = new Vue({
        el: '#app',
        data() {
            return {
                po_list: {!!$po->purchaseOrderLists!!},
                receives_list: {!!$receive->receive_lists!!},
                po_list_real: {!!$po->purchaseOrderLists!!},
                po_vat_type: '{{$po->vat_type}}',
                po_sum_price: '{{$po->sum_price}}',
                receive: {
                    project_id: '{{$po->project->id}}',
                    po_id: '{{$po->id}}',
                    user_id: '{{auth()->user()->id}}',
                    date: '{{$receive->date}}',
                    type: '{{$type}}',
                    po_remain: 0,
                    po_remain_percent: 0,
                    note: '',
                    supplier_id: 'เลือก',
                    payment_condition: '{{$receive->payment_condition}}',
                },
                price: {
                    sum_price: 0,
                    vat_amount: 0,
                    sum: 0,
                    special_discount: '{{($po->special_discount - $po->receive_special_discount) + $receive->special_discount}}',
                    receive_special_discount: '{{$po->receive_special_discount - $receive->special_discount}}',
                },
                arr1: new Array(),
                duedate: {
                    start: '{{Carbon\Carbon::today()->format("Y-m-d")}}',
                    finish: '{{Carbon\Carbon::today()->format("Y-m-d")}}'
                },
                type: '{{$type}}',
                cut: 0,
                file_names: new Array(),
                files: new Array(),
                retention: '{{$receive->retention ? $receive->retention->price : 0}}',
                current_files: {!!$receive->receive_files!!},
            }
        },
        mounted() {
            this.receive.supplier_id = '{{$po->supplier_id}}';

            for(var i = 0; i < this.po_list.length; i++){
                for(var x = 0; x < this.receives_list.length; x++){
                    if(this.po_list[i].id == this.receives_list[x].po_list_id){
                        this.po_list[i].received = parseFloat(this.po_list[i].received) - parseFloat(this.receives_list[x].amount);
                        this.po_list[i].receive_special_discount = parseFloat(this.po_list[i].receive_special_discount) - parseFloat(this.receives_list[x].special_discount);
                    }
                }
            }

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            })
            $('#start').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            })
            $('#finish').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            })

            this.arr1.push({
                file: ''
            });

            this.first_cal();
        },
        methods: {
            first_cal(){
                var _total = 0;
                var cut = 0;
                for (var i = 0; i < this.po_list.length; i++) {
                    this.po_list[i].amount = this.po_list[i].amount - this.po_list[i].received;
                    this.po_list[i].special_discount = this.po_list[i].special_discount - this.po_list[i].receive_special_discount;
                    this.po_list[i].price = (this.po_list[i].amount * (this.po_list[i].unit_price - this.po_list[i].unit_discount)).toFixed(2);

                    this.po_list[i].price = (this.po_list[i].price - this.po_list[i].special_discount).toFixed(2);
                    _total = _total + parseFloat(this.po_list[i].price);
                }

                _total = _total - this.price.special_discount;

                for (var i = 0; i < this.po_list_real.length; i++) {
                    var state = true;
                    for(var x = 0; x < this.receives_list.length; x++){
                        if(this.po_list_real[i].id == this.receives_list[x].po_list_id){
                            state = false;
                        }
                    }

                    if(state){
                        cut = parseFloat(cut) + parseFloat(((this.po_list_real[i].received * (this.po_list_real[i].unit_price - this.po_list_real[i].unit_discount)) - this.po_list_real[i].receive_special_discount));
                    }
                }

                if (this.po_vat_type == 'นอก') {
                    this.price.sum_price = _total;
                    this.price.vat_amount = _total * 0.07;
                    this.price.sum = this.price.sum_price + this.price.vat_amount;
                } else if (this.po_vat_type == 'ใน') {
                    this.price.sum_price = _total / 1.07;
                    this.price.vat_amount = _total - this.price.sum_price;
                    this.price.sum = this.price.sum_price + this.price.vat_amount;
                } else {
                    this.price.sum_price = _total;
                    this.price.vat_amount = 0;
                    this.price.sum = this.price.sum_price + this.price.vat_amount;
                }

                console.log(_total, cut, this.price.receive_special_discount)
                
                if (this.po_vat_type == 'ใน') {
                    this.receive.po_remain = (parseFloat(this.po_sum_price - ((_total + cut - parseFloat(this.price.receive_special_discount)) / 1.07))).toFixed(2)
                } else {
                    this.receive.po_remain = (parseFloat(this.po_sum_price - (_total + cut - parseFloat(this.price.receive_special_discount)))).toFixed(2)
                }

                this.receive.po_remain_percent = (parseFloat(this.receive.po_remain) / parseFloat(this.po_sum_price)) * 100;
            },
            cal_price() {
                var _total = 0;
                var cut = 0;
                for (var i = 0; i < this.po_list.length; i++) {
                    this.po_list[i].price = (this.po_list[i].amount * (this.po_list[i].unit_price - this.po_list[i].unit_discount)).toFixed(2);
                    this.po_list[i].price = (this.po_list[i].price - this.po_list[i].special_discount).toFixed(2);

                    _total = _total + parseFloat(this.po_list[i].price);
                }

                _total = _total - this.price.special_discount;

                for (var i = 0; i < this.po_list_real.length; i++) {
                    var state = true;
                    for(var x = 0; x < this.receives_list.length; x++){
                        if(this.po_list_real[i].id == this.receives_list[x].po_list_id){
                            state = false;
                        }
                    }

                    if(state){
                        cut = parseFloat(cut) + parseFloat(((this.po_list_real[i].received * (this.po_list_real[i].unit_price - this.po_list_real[i].unit_discount)) - this.po_list_real[i].receive_special_discount));
                    }
                }

                if (this.po_vat_type == 'นอก') {
                    this.price.sum_price = _total;
                    this.price.vat_amount = _total * 0.07;
                    this.price.sum = this.price.sum_price + this.price.vat_amount;
                } else if (this.po_vat_type == 'ใน') {
                    this.price.sum_price = _total / 1.07;
                    this.price.vat_amount = _total - this.price.sum_price;
                    this.price.sum = this.price.sum_price + this.price.vat_amount;
                } else {
                    this.price.sum_price = _total;
                    this.price.vat_amount = 0;
                    this.price.sum = this.price.sum_price + this.price.vat_amount;
                }

                if (this.po_vat_type == 'ใน') {
                    this.receive.po_remain = (parseFloat(this.po_sum_price - ((_total + cut - parseFloat(this.price.receive_special_discount)) / 1.07))).toFixed(2)
                } else {
                    this.receive.po_remain = (parseFloat(this.po_sum_price - (_total + cut - parseFloat(this.price.receive_special_discount)))).toFixed(2)
                }

                this.receive.po_remain_percent = (parseFloat(this.receive.po_remain) / parseFloat(this.po_sum_price)) * 100;
            },
            numer(value) {
                return (numeral(value).format('0,0.00'));
            },
            remove(id) {
                this.po_list.splice(id, 1);

                this.cal_price();
            },
            add1() {
                this.arr1.push({
                    file: ''
                });
            },
            remove1(id) {
                this.arr1.splice(id, 1);
            },
            remove_file(id) {
                this.file_names.splice(id, 1);
                this.files.splice(id, 1);
            },
            submit: async function() {
                if (this.receive.supplier_id == 'เลือก') {
                    alert('เลือกผู้ขาย ?');
                    return;
                }

                if (this.po_list.length == 0) {
                    alert('กรอกข้อมูลให้ถูกต้อง ?');
                    return;
                }

                if(this.retention < 0){
                    alert('กรอกข้อมูลให้ถูกต้อง ?');
                    return;
                }

                if (confirm('ยืนยันการรับของ ?')) {
                    document.getElementById('btn_submit').style.display = 'none';
                    document.getElementById('btn_loading').style.display = 'block';

                    console.log(this.po_list);
                    
                    var res = await axios.post('/receive/approve/update', {
                        receive: this.receive,
                        po_list: this.po_list,
                        duedate: this.duedate,
                        price: this.price,
                        files: this.files,
                        retention: this.retention,
                        current_files: this.current_files,
                        receive_id: '{{$receive->id}}',
                    });

                    document.getElementById('btn_submit').style.display = 'block';
                    document.getElementById('btn_loading').style.display = 'none';
                }

                history.replaceState({urlPath:'/receive/edit/' + '{{$receive->id}}' + '/' + this.type},"",'/')
                location.href = '/receive';
            },
            onFileChange(e) {
                this.file_names.push(e.target.files[0]);
                console.log(this.file_names)
                this.createImage(e.target.files[0])
            },
            createImage(file) {
                let reader = new FileReader();
                reader.onload = e => {
                    this.files.push(e.target.result);
                };
                reader.readAsDataURL(file);
            },
            price_change(index){
                this.po_list[index].amount = (this.po_list[index].price / this.po_list[index].unit_price).toFixed(17);

                this.cal_price();
            }
        },
    });
</script>
@endsection