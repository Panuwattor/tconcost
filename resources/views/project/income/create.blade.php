@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">แผนรายรับโครงการ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/project/show/{{$project->id}}">โครงการ</a></li>
                    <li class="breadcrumb-item active">แผนรายรับโครงการ</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" id="app">
    @include('project.heade')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">รายรับโครงการ</h3>
        </div>
        <div class="card-body">
            <form action="/project/create-income/{{$project->id}}" method="post">
                @csrf
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>โครงการ</label>
                            <input type="text" readonly class="form-control form-control-sm" placeholder="Enter ..." value="{{$project->name}}">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>ลูกค้า</label>
                            <input type="text" readonly class="form-control form-control-sm" placeholder="Enter ..." value="{{$project->customer->name}}">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>สาขา</label>
                            <input type="text" readonly class="form-control form-control-sm" placeholder="Enter ..." value="{{$project->branch->name}}">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Deposit</label>
                                    <input type="text" readonly class="form-control form-control-sm" placeholder="Enter ..." v-model="numer(deposit)">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>%</label>
                                    <input type="text" readonly class="form-control form-control-sm" placeholder="Enter ..." v-model="deposit_percent">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>มูลค่าสัญญา</label>
                            <input type="text" readonly class="form-control form-control-sm" placeholder="Enter ..." value="{{number_format($project->project_cost, 2)}}">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Adjust Amount</label>
                            <input type="text" readonly class="form-control form-control-sm" placeholder="Enter ..." v-model="numer(adjust)">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Total Amount</label>
                            <input type="text" readonly class="form-control form-control-sm" placeholder="Enter ..." v-model="numer(total)">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Retention</label>
                                    <input type="text" readonly class="form-control form-control-sm" placeholder="Enter ..." v-model="numer(retention)">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>%</label>
                                    <input type="text" readonly class="form-control form-control-sm" placeholder="Enter ..." v-model="retention_percent">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12" style="font-size: 10pt;">
                        <button class="btn btn-sm btn-block btn-outline-secondary w-auto" @click="addrow()"><i class="fa fa-plus"></i> เพิ่มแถว</button>
                        <div class="card-body table-responsive p-0">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>ลำดับ</th>
                                        <th>ประเภท</th>
                                        <th>รายละเอียด</th>
                                        <th>หน่วย</th>
                                        <th>จำนวนเงิน</th>
                                        <th>%</th>
                                        <th>ส่วนลด</th>
                                        <th style="display: none;">หัก</th>
                                        <th>รวม</th>
                                        <th>วันที่ครบกำหนด</th>
                                        <th>note</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(interim, index) in interims">
                                        <td style="text-align: center; vertical-align: middle; padding: 0px; top: 50%;">@{{index + 1}}</td>
                                        <td style="padding: 0px; vertical-align: middle;">
                                            <select name="type[]" id="type" style="padding: 3px; border-radius: 5px;" v-model="interim.type">
                                                <option value="งวดงาน">งวดงาน</option>
                                                <option value="เงินเบิกล่วงหน้า">เงินเบิกล่วงหน้า</option>
                                                <option value="ประกันผลงาน">ประกันผลงาน</option>
                                            </select>
                                        </td>
                                        <td style="padding: 0px; vertical-align: middle;">
                                            <textarea required style="border: 0px; border-radius: 0px;" name="description[]" class="form-control text-sm" placeholder="description" v-model="interim.description" cols="30" rows="2"></textarea>
                                        </td>
                                        <td style="padding: 0px; vertical-align: middle;">
                                            <input autocomplete="off" readonly style="width: 100%; border: 0px; border-radius: 0px; text-align: center;" type="text" name="unit[]" value="งวด" v-model="interim.unit">
                                        </td>
                                        <td style="padding: 0px; vertical-align: middle;">
                                            <input autocomplete="off" required style="width: 100%; border: 0px; border-radius: 0px; text-align: center;" type="text" name="price[]" placeholder="0.00" v-model="interim.price" @change="cal_percent(index)">
                                        </td>
                                        <td style="padding: 0px; vertical-align: middle;">
                                            <input autocomplete="off" style="width: 100%; border: 0px; border-radius: 0px; text-align: center;" type="text" name="percent[]" placeholder="0" v-model="interim.percent" @change="cal_price(index)">
                                        </td>
                                        <td style="padding: 0px; vertical-align: middle;">
                                            <input autocomplete="off" style="width: 100%; border: 0px; border-radius: 0px; text-align: center;" type="text" name="discount[]" placeholder="0.00" v-model="interim.discount" @change="cal_total(index)">
                                        </td>
                                        <td style="padding: 0px; vertical-align: middle;">
                                            <input autocomplete="off" style="width: 100%; border: 0px; border-radius: 0px; text-align: center;" type="text" name="total[]" placeholder="0.00" v-model="interim.total">
                                        </td>
                                        <td style="padding: 0px; vertical-align: middle;">
                                            <input type="date" style="width: 100%; border: 0px; border-radius: 0px; text-align: right;" name="date[]" v-model="interim.date"></input>
                                        </td>
                                        <td style="padding: 0px; vertical-align: middle;">
                                            <textarea style="border: 0px; border-radius: 0px;" name="note[]" placeholder="note" v-model="interim.note" cols="10" rows="1"></textarea>
                                        </td>
                                        <td style="text-align: center; padding: 0px; vertical-align: middle;">
                                            <i class="fa fa-trash text-danger" @click="remove(index)"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" style="float: right;" class="btn w-auto btn-outline-success mt-5">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('header')
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
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
        left: 40%;
        top: 40%;
    }
</style>
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js" integrity="sha256-T/f7Sju1ZfNNfBh7skWn0idlCBcI3RwdLSS4/I7NQKQ=" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>

<script>
    Vue.component('my-date-picker',{
        template: '<input required style="width: fit-content; border: 0px; border-radius: 0px; text-align: center;" type="text" name="date[]" autocomplete="off" v-datepicker :value="value" @input="update($event.target.value)">',
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
                interims: new Array(),
                project_cost: '{{$project->project_cost}}',
                adjust: 0,
                total: 0,
                deposit: 0,
                deposit_percent: 0,
                retention: 0,
                retention_percent: 0,
            }
        },
        mounted: async function() {
            await this.interims.push({
                contract: 'contract',
                type: 'งวดงาน',
                date: '{{\Carbon\Carbon::today()->format("Y-m-d")}}',
                description: '',
                unit: 'งวด',
                price: '0',
                percent: '0',
                discount: '0',
                deposit: '0',
                retention: '0',
                total: 0,
                note: '',
            });

            for (var i = 0; i < this.interims.length; i++) {
                $('#date' + i).datepicker({
                    autoclose: true,
                    format: "yyyy-mm-dd",
                })
            }
        },
        methods: {
            addrow: async function() {
                await this.interims.push({
                    type: 'งวดงาน',
                    date: '{{\Carbon\Carbon::today()->format("Y-m-d")}}',
                    description: '',
                    unit: 'งวด',
                    price: '0',
                    percent: '0',
                    discount: '0',
                    deposit: '0',
                    retention: '0',
                    total: '',
                    note: '',
                });

                for (var i = 0; i < this.interims.length; i++) {
                    $('#date' + i).datepicker({
                        autoclose: true,
                        format: "yyyy-mm-dd",
                    })
                }
            },
            remove: async function(index) {
                await this.interims.splice(index, 1);

                this.cal_amount();
            },
            cal_price(index) {
                this.interims[index].price = (this.interims[index].percent * this.project_cost) / 100;

                this.cal_total(index)
            },
            cal_percent(index) {
                this.interims[index].percent = (this.interims[index].price / this.project_cost) * 100;

                this.cal_total(index)
            },
            cal_total(index) {
                this.interims[index].total = parseFloat(this.interims[index].price) - parseFloat(this.interims[index].discount) - parseFloat(this.interims[index].deposit) - parseFloat(this.interims[index].retention);

                this.cal_amount();
            },
            cal_amount() {
                var _adjust = 0,
                    _total = 0,
                    _deposit = 0,
                    _deposit_percent = 0,
                    _retention = 0,
                    _retention_percent = 0;

                for (var x = 0; x < this.interims.length; x++) {
                    if (this.interims[x].type == 'Payment') {
                        _total = _total + parseFloat(this.interims[x].price)
                    } else if (this.interims[x].type == 'Deposit') {
                        _deposit = _deposit + parseFloat(this.interims[x].price)
                    }

                    _retention = _retention + parseFloat(this.interims[x].retention)
                }

                this.total = _total;
                this.deposit = _deposit;
                this.deposit_percent = (_deposit / this.project_cost) * 100;
                this.retention = _retention;
                this.retention_percent = (_retention / this.project_cost) * 100;

                if (_total > this.project_cost) {
                    this.adjust = _total - this.project_cost;
                } else {
                    this.adjust = 0;
                }
            },
            numer(number) {
                return numeral(number).format('0,0.00');
            },
        },
    });
</script>
@endsection