@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">แผนต้นทุน</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">แผนต้นทุน</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">กลุ่มต้นทุน</h3>
            <div class="card-tools">
                @if($costplans->count() == 0)
                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#modal-cost-plan">เพิ่มกลุ่มต้นทุน (มาตรฐาน)</button>
                @endif
                <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#modal-add">เพิ่มกลุ่มต้นทุน (กำหนดเอง)</button>
                <!-- <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#modal-addsub">เพิ่มรายการย่อย (กำหนดเอง)</button> -->
            </div>
            <div class="modal fade" id="modal-cost-plan">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">เพิ่มกลุ่มต้นทุน (มาตรฐาน)</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/cost-plan-list-auto" method="post">
                            @csrf
                            <div class="modal-body">
                                @foreach(config('costplan.cost_plans') as $no=>$cost_plan)
                                {{$no}} {{$cost_plan}}
                                    <ul>
                                        @foreach(config('costplan.cost_plan_lists'.$no) as $key=>$list)
                                        <li>{{$list}}</li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">เพิ่มกลุ่มต้นทุน (มาตรฐาน)</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- <div class="modal fade" id="modal-addsub">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">รายการย่อย</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/cost-plan-list" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <span for="inputEmail3">ชื่อ <span class="text-danger">*</span></span>
                                            <div>
                                                <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">กลุ่มต้นทุน <span class="text-danger">*</span></span>
                                            <div>
                                                <select required class="form-control select2" name="cost_plan_id" id="cost_plan_id">
                                                    @foreach($costplans as $i => $costplan)
                                                    <option value="{{$costplan->id}}">{{$costplan->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">note </span>
                                            <div>
                                                <textarea name="note" id="note" cols="30" rows="3" class="form-control" placeholder="Enter....."></textarea>
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
            </div> -->

            <div class="modal fade" id="modal-add">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">กลุ่มต้นทุน</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/cost-plan" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <span for="inputEmail3">ชื่อ <span class="text-danger">*</span></span>
                                            <div>
                                                <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">note </span>
                                            <div>
                                                <textarea name="note" id="note" cols="30" rows="3" class="form-control" placeholder="Enter....."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">เพิ่มกลุ่มต้นทุน (กำหนดเอง)</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach($costplans as $i => $costplan)
            <div class="card collapsed-card" style="margin-bottom: 0px; border-radius: 0px">
                <div class="card-header" style="background-color: #ddd;">
                    <h3 class="card-title">
                        {{$i + 1}} . {{$costplan->name}} <small>@if($costplan->note)({{$costplan->note}})@endif</small>
                        &nbsp;<i class="fas fa-edit" style="color: gray;" data-toggle="modal" data-target="#modal-edit{{$costplan->id}}"></i>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#modal-addsub{{$costplan->id}}">เพิ่มรายการย่อย</button>
                        <div class="modal fade" id="modal-addsub{{$costplan->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">รายการย่อย</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/cost-plan-list" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group">
                                                        <span for="inputEmail3">ชื่อ <span class="text-danger">*</span></span>
                                                        <div>
                                                            <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <span for="inputEmail3">กลุ่มต้นทุน <span class="text-danger">*</span></span>
                                                        <div>
                                                            <select required class="form-control" name="cost_plan_id" id="cost_plan_id">
                                                                <option value="{{$costplan->id}}">{{$costplan->name}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <span for="inputEmail3">note </span>
                                                        <div>
                                                            <textarea name="note" id="note" cols="30" rows="3" class="form-control" placeholder="Enter....."></textarea>
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
                </div>
                @foreach($costplan->costPlanLists as $i => $costplanlist)
                <div class="card collapsed-card" style="margin-bottom: 0px; border-radius: 0px">
                    <div class="card-header">
                        <h3 class="card-title">#{{$costplanlist->code}} {{$costplanlist->name}} <small>@if($costplanlist->note)({{$costplanlist->note}})@endif</small></h3> &nbsp;<i class="fas fa-edit" style="color: gray;" data-toggle="modal" data-target="#modal-editlist{{$costplanlist->id}}"></i>
                    </div>
                </div>

                <div class="modal fade" id="modal-editlist{{$costplanlist->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">แก้ไขรายการย่อย</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/cost-plan-list/update/{{$costplanlist->id}}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <span for="inputEmail3"># <span class="text-danger">*</span></span>
                                                <div>
                                                    <input required type="text" class="form-control" id="code" name="code" readonly value="{{$costplanlist->code}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <span for="inputEmail3">ชื่อ <span class="text-danger">*</span></span>
                                                <div>
                                                    <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ" value="{{$costplanlist->name}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <span for="inputEmail3">กลุ่มต้นทุน <span class="text-danger">*</span></span>
                                                <div>
                                                    <select required class="form-control" name="cost_plan_id" id="cost_plan_id">
                                                        <option value="{{$costplanlist->cost_plan_id}}">{{$costplanlist->cost_plan->name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <span for="inputEmail3">note </span>
                                                <div>
                                                    <textarea name="note" id="note" cols="30" rows="3" class="form-control" placeholder="Enter.....">{{$costplanlist->note}}</textarea>
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
                @endforeach
            </div>
            <div class="modal fade" id="modal-edit{{$costplan->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">กลุ่มต้นทุน</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/cost-plan/update/{{$costplan->id}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <span for="inputEmail3">ชื่อ <span class="text-danger">*</span></span>
                                            <div>
                                                <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ" value="{{$costplan->name}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">note </span>
                                            <div>
                                                <textarea name="note" id="note" cols="30" rows="3" class="form-control" placeholder="Enter.....">{{$costplan->note}}</textarea>
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
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('header')
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

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
        height: 31px !important;
        padding-top: 5px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>

<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
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
</script>

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
@endsection