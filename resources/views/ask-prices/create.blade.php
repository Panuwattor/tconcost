@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">ขอราคา</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="/ask-price">รายการขอราคา</a></li>
                    <li class="breadcrumb-item active">ขอราคา</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<form action="/ask-price/create" method="post" enctype="multipart/form-data" onsubmit="return confirm('ยืนยันสร้างใบขอราคา ข้อมูลขอราคาถูกต้อง ?')"  id="app">
    @csrf
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">ขอราคา</h3>
        </div>
        <div class="card-body row">
            <div class="col-12 col-md-6">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Order <span class="text-danger"><b>*</b></span></label>
                    <div class="col-sm-10">
                        <select required class="form-control select2" name="project_id" id="project_id" onchange="setAddress()">
                            <option value="">เลือก</option>
                            @foreach($projects as $project)
                            <option value="{{$project->id}}">{{$project->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ผู้รับผิดชอบ <span class="text-danger"><b>*</b></span></label>
                    <div class="col-sm-10">
                        <select required class="form-control select2" name="main_user_id" id="main_user_id">
                            <option value="">เลือก</option>
                            @foreach($main_users as $main_user)
                            <option value="{{$main_user->id}}">{{$main_user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">โทรศัพท์ <span class="text-danger"><b>*</b></span></label>
                    <div class="col-sm-10">
                        <input required type="text" class="form-control" name="tel" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">วันที่ขอซื้อ <span class="text-danger"><b>*</b></span></label>
                    <div class="col-sm-10">
                        <input required autocomplete="off" type="text" name="ap_date" class="form-control" id="ap_date" value="{{Carbon\Carbon::today()->format('Y-m-d')}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">วันที่หมดอายุ <span class="text-danger"><b>*</b></span></label>
                    <div class="col-sm-10">
                        <input required autocomplete="off" type="text" name="finish_date" class="form-control" id="finish_date" value="{{Carbon\Carbon::today()->format('Y-m-d')}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ไฟล์</label>
                    <div class="col-sm-10">
                        <div class="custom-file">
                            <input type="file" name="photo" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">วิธีจัดส่ง <span class="text-danger"><b>*</b></span></label>
                    <div class="col-sm-10">
                        <textarea required name="delivery" id="delivery" class="form-control" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ที่อยู่ <span class="text-danger"><b>*</b></span></label>
                    <div class="col-sm-10">
                        <textarea required name="address" id="address" class="form-control" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">รายละเอียด</label>
                    <div class="col-sm-10">
                        <textarea name="note" id="note" class="form-control" cols="30" rows="3"></textarea>
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
                            <th>รายการ</th>
                            <th>จำนวน</th>
                            <th>หน่วย</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in arr">
                            <td>@{{index + 1}}</td>
                            <td>
                                <input v-model="item.name" required type="text" name="name[]" id="name" class="form-control" placeholder="รายการ">
                            </td>
                            <td>
                                <input v-model="item.amount" required type="number" name="amount[]" id="amount" class="form-control" placeholder="จำนวน" step="any">
                            </td>
                            <td>
                                <input v-model="item.unit" required type="text" name="unit[]" id="unit" class="form-control" placeholder="หน่วย">
                            </td>
                            <td>
                                <i class="fa fa-close text-danger" @click="remove(index)" v-if="arr.length > 1"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <br>
                <button type="button" class="form-control w-auto bg-info" @click="add()">เพิ่มแถวใหม่</button>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Supplier</h3>
        </div>
        <div class="card-body row">
           <div class="col-12 col-md-4">
           <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item1, index1) in arr1">
                            <td>@{{index1 + 1}}</td>
                            <td>
                                <select required class="form-control" name="supplier_id[]">
                                    <option value="">เลือก</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <i class="fa fa-close text-danger" @click="remove1(index1)" v-if="arr1.length > 1"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <br>
                <button type="button" class="form-control w-auto bg-info" @click="add1()">เพิ่มแถวใหม่</button>
            </div>
           </div>
        </div>
        <div class="card-body row">
            <div class="col-12">
                <button type="submit" class="form-control w-auto bg-success w-auto" style="float: right;"><i class="fa fa-save"></i> ยืนยันขอราคา</button>
            </div>
        </div>
        <br>
    </div>
</form>
<br>
<br>
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
        padding-top: 10px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<!-- bs-custom-file-input -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- vue cdn -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<!-- Select2 -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/js/select2.full.min.js"></script>
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
                document.getElementById('address').value = projects[i].address
            }
        }
    }
</script>

<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                arr: new Array(),
                arr1: new Array(),
            }
        },
        mounted() {
            $('#ap_date').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            })
            $('#finish_date').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            })
        },
        created() {
            this.arr.push({
                name: '',
                amount: '',
                unit: ''
            });
            
            this.arr1.push({
                name: '',
                amount: '',
                unit: ''
            });
        },
        methods: {
            add() {
                this.arr.push({
                    name: '',
                    amount: '',
                    unit: ''
                });
                //Initialize Select2 Elements
                $('.select2').select2({width: '100%'})
            },
            remove(id) {
                this.arr.splice(id, 1);
            },
            add1() {
                this.arr1.push({
                    name: '',
                    amount: '',
                    unit: ''
                });
            },
            remove1(id) {
                this.arr1.splice(id, 1);
            }
        },
    });
</script>
@endsection