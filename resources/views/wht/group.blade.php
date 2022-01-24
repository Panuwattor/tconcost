@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">หมวด หัก ณ ที่จ่าย</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">หมวด หัก ณ ที่จ่าย</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card" id="app">
    <div class="card-header">
        <h3 class="card-title">หมวด หัก ณ ที่จ่าย</h3>
    </div>
    <div class="card-body table-responsive">
        <form action="/wht/group" method="post" onsubmit="return confirm('ยืนยันบันทึกข้อมูล ?')">
            @csrf
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label>ชื่อหมวด</label>
                        <div>
                            <input autocomplete="off" required type="text" name="name" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-1">
                    <div class="form-group">
                        <label>เปอร์เซ็นต์</label>
                        <div>
                            <input autocomplete="off" required type="number" step="any" name="percent" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label>หมายเหตุ</label>
                        <div>
                            <input autocomplete="off" type="text" name="note" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-1">
                    <div class="form-group">
                        <label style="visibility: hidden;">เพิ่ม</label>
                        <div>
                            <button type="submit" class="btn btn-block btn-outline-info btn-sm">เพิ่ม</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-12">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Name</th>
                            <th>Percent</th>
                            <th>note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wht_groups as $i => $wht_group)
                        <tr class="text-center">
                            <td>{{$i + 1}}</td>
                            <td>{{$wht_group->name}}</td>
                            <td>{{$wht_group->percent}}</td>
                            <td>{{$wht_group->note}}</td>
                            <td>
                                <button type="submit" class="btn btn-outline-warning btn-xs" data-toggle="modal" data-target="#modal-default{{$i}}">แก้ไข</button>
                            </td>
                        </tr>

                        <div class="modal fade" id="modal-default{{$i}}">
                            <div class="modal-dialog modal-xs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">แก้ไข</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/wht/group/update" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="wht_group_id" value="{{$wht_group->id}}">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>ชื่อหมวด</label>
                                                        <div>
                                                            <input autocomplete="off" required type="text" name="name" class="form-control form-control-sm" value="{{$wht_group->name}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>เปอร์เซ็นต์</label>
                                                        <div>
                                                            <input autocomplete="off" required type="number" step="any" name="percent" class="form-control form-control-sm" value="{{$wht_group->percent}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>หมายเหตุ</label>
                                                        <div>
                                                            <input autocomplete="off" type="text" name="note" class="form-control form-control-sm" value="{{$wht_group->note}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                                            <button type="submit" class="btn btn-primary">แก้ไข</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
        height: 31px !important;
        padding-top: 5px !important;
        user-select: none;
        -webkit-user-select: none;
        border-radius: 0px;
    }
</style>
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<!-- Select2 -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({width: '100%'})

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#date').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        })
    })
</script>
@endsection