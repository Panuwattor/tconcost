@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">โครงการ </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/project">รายการโครงการ</a></li>
                    <li class="breadcrumb-item active">โครงการ</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    @include('project.heade')
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลโครงการ {!!$project->state!!}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-block btn-outline-info btn-sm" data-toggle="modal" data-target="#modal-add">แก้ไข</button>
                    </div>
                    <div class="modal fade" id="modal-add">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">แก้ไขโครงการ</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/project/update/{{$project->id}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" type="radio" id="customRadio_type1" value="0" name="type" @if($project->type == 0) checked @endif>
                                                                <label for="customRadio_type1" class="custom-control-label">โครงการทั่วไป</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input" type="radio" id="customRadio_type2" value="1" name="type" @if($project->type == 1) checked @endif>
                                                                <label for="customRadio_type2" class="custom-control-label">โครงการภายใน</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">ชื่อโครงการ <span class="text-danger">*</span></span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ" value="{{$project->name}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">รหัสโครงการ <span class="text-danger">*</span></span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="code" name="code" placeholder="รหัสโครงการ" value="{{$project->code}}">
                                                    </div>
                                                </div>
                                                <div class="form-group" hidden>
                                                    <span for="inputEmail3">สาขา <span class="text-danger">*</span></span>
                                                    <div>
                                                        <select required name="branch_id" class="form-control select2" id="">
                                                            @foreach($branchs as $branch)
                                                            <option value="{{$branch->id}}" @if($branch->id == $project->branch_id) selected @endif>{{$branch->code}} {{$branch->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">ชื่อลูกค้า <span class="text-danger">*</span></span>
                                                    <div>
                                                        <select required name="customer_id" class="form-control select2" id="">
                                                            @foreach($customers as $customer)
                                                            <option value="{{$customer->id}}" @if($customer->id == $project->customer_id) selected @endif>{{$customer->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">ประเภทโครงการ <span class="text-danger">*</span></span>
                                                    <div>
                                                        <select required name="project_type_id" class="form-control select2" id="">
                                                            @foreach($project_types as $project_type)
                                                            <option value="{{$project_type->id}}" @if($project_type->id == $project->project_type_id) selected @endif>{{$project_type->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span required for="inputEmail3">มูลค่าสัญญา (ไม่รวม VAT) <span class="text-danger">*</span></span>
                                                    <div>
                                                        <input required type="number" class="form-control" id="inputEmail3" name="project_cost" placeholder="มูลค่าสัญญา" value="{{$project->project_cost}}" step="any">
                                                    </div>
                                                </div>
                                                <div class="form-group" onclick="check_vat()">
                                                    <span for="inputEmail3">VAT</span>
                                                    <div>
                                                        <input type="number" class="form-control" id="vat" name="vat" placeholder="VAT" value="{{$project->vat}}" step="any">
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="customRadio2" value="ใน" name="vat_type" @if($project->vat_type == 'ใน') checked @endif>
                                                            <label for="customRadio2" class="custom-control-label">Vat ใน</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="customRadio1" value="นอก" name="vat_type" @if($project->vat_type == 'นอก') checked @endif>
                                                            <label for="customRadio1" class="custom-control-label">Vat นอก</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="customRadio3" value="ไม่มี" name="vat_type" @if($project->vat_type == 'ไม่มี') checked @endif>
                                                            <label for="customRadio3" class="custom-control-label">ไม่มี Vat</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">ผู้รับผิดชอบโครงการ <span class="text-danger">*</span></span>
                                                    <div>
                                                        <select required name="main_user_id" class="form-control select2" id="">
                                                            @foreach($users as $user)
                                                            <option value="{{$user->id}}" @if($user->id == $project->main_user_id) selected @endif>{{$user->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <span for="inputEmail3">ที่อยู่ <span class="text-danger">*</span></span>
                                                    <div>
                                                        <textarea required class="form-control" rows="3" name="address" placeholder="Enter ...">{{$project->address}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <span for="inputEmail3">วันที่เริ่มต้น <span class="text-danger">*</span></span>
                                                        <div>
                                                            <input required autocomplete="off" type="text" name="start_date" class="form-control" id="datepicker" value="{{$project->start_date}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <span for="inputEmail3">วันที่สิ้นสุด <span class="text-danger">*</span></span>
                                                        <div>
                                                            <input required autocomplete="off" type="text" name="finish_date" class="form-control" id="finish_datepicker" value="{{$project->finish_date}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">รายละเอียด</span>
                                                    <div>
                                                        <textarea class="form-control" rows="3" name="note" placeholder="Enter ...">{{$project->note}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6" hidden>
                                                    <div class="form-group">
                                                        <span for="inputEmail3">ปี <span class="text-danger">*</span></span>
                                                        <div>
                                                            <input required autocomplete="off" type="text" name="year" class="form-control" id="year" value="{{$project->year}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <span for="inputEmail3">ชื่อโครงการ : <strong style="color:#0E710A;">{{$project->name}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">รหัสโครงการ : <strong style="color:#0E710A;">{{$project->code}}</strong></span>
                            </div>
                            <!-- <div class="form-group">
                                <span for="inputEmail3">สาขา : <strong style="color:#0E710A;">{{$project->branch->name}}</strong></span>
                            </div> -->
                            <div class="form-group">
                                <a href="/customer/{{$project->customer->id}}/show" for="inputEmail3">ลูกค้า : <strong style="color:#0E710A;">{{$project->customer->name}}</strong></a>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">ประเภทโครงการ : <strong style="color:#0E710A;">{{$project->project_type->name}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">มูลค่าสัญญา (ไม่รวม VAT) : <strong style="color:#0E710A;">{{number_format($project->project_cost, 2)}}</strong></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <span for="inputEmail3">VAT {{$project->vat_type}} : <strong style="color:#0E710A;">{{number_format($project->vat, 2)}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">ผู้รับผิดชอบโครงการ : <strong style="color:#0E710A;">{{$project->main_user->name}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">ที่อยู่ : <strong style="color:#0E710A;">{{$project->address}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">วันที่เริ่มต้น : <strong style="color:#0E710A;">{{$project->start_date}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">วันที่สิ้นสุด : <strong style="color:#0E710A;">{{$project->finish_date}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">รายละเอียด : <strong style="color:#0E710A;">{{$project->note}}</strong></span>
                            </div>
                        </div>
                        @if($project->quotation)
                        <div class="col-md-12">
                            <div class="form-group">
                                <span for="inputEmail3">ใบเสนอราคา : <strong style="color:#0E710A;"><a href="/sale/quotation/{{$project->quotation->id}}/show"> <i class="fa fa-file-text-o"></i> {{$project->quotation->code}} </a> </strong></span>
                            </div>
                               
                        </div>
                        @endif
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลลูกค้า</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <span for="inputEmail3">ชื่อ : <strong style="color:#0E710A;">{{$project->customer->name}}</strong></span>
                            </div>
                            <div class="form-group">
                                <span for="inputEmail3">ที่อยู่ : <strong style="color:#0E710A;">{{$project->customer->address}}</strong></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <span for="inputEmail3">โทรศัพท์ : <strong style="color:#0E710A;">{{$project->customer->tel}}</strong></span>
                            </div>

                            <div class="form-group">
                                <span for="inputEmail3">note : <strong style="color:#0E710A;">{{$project->customer->note}}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <a href="/project/show/{{$project->id}}/logs" class="btn btn-tool text-info btn-sm">
                            <i class="fas fa-bars"></i> ทั้งหมด
                        </a>
                    </div>
                    <h3 class="card-title"><i class="fa fa-floppy-o"></i> Logs บันทึกการทำงาน</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 10px">#</th>
                                <th>user</th>
                                <th>type</th>
                                <th>note</th>
                                <th>time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->logs()->with('user')->orderBy('created_at','desc')->limit(5)->get() as $no=>$log)
                            <tr class="text-center">
                                <td>{{$no+1}}</td>
                                <td>{{$log->user->name}}</td>
                                <td> <a href="{{$log->link}}" target="back"> {{$log->type}}</a></td>
                                <td>{{$log->note}}</td>
                                <td>{{$log->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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