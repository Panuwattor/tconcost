@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">สั่งจ้าง </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">สั่งจ้าง </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
    <form action="/sc/search_report" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                            <div class="col-12 col-md-3">
                                <select  name="project_id" class="form-control form-control-sm select2" id="">
                                    <option value='' >ทั้งหมด</option>
                                    @foreach($projects as $project)                            
                                    <option value="{{$project->id}}" @if($project->id == $project_id) selected @endif >{{$project->code}} {{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-2">
                                <select name="date_type" class="form-control form-control-sm">
                                    <option value="create_date" @if($date_type=='create_date' ) selected @endif>วันที่สร้าง</option>
                                    <option value="date" @if($date_type=='date' ) selected @endif>วันที่เปิด PO</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-2">
                                <input readonly type="text" autocomplete="off" class="form-control form-control-sm" name="from" value="{{$from}}" id="from">
                            </div>
                            <div class="col-12 col-md-2">
                                <input readonly type="text" autocomplete="off" class="form-control form-control-sm" name="to" value="{{$to}}" id="to">
                            </div>

                            <div class="col-12 col-md-1">
                                <button style="float: right;" class="btn-sm w-auto btn-outline-success "> <i class="fa fa-search"></i> ค้นหา</button>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline ml-3">
                                                <input type="checkbox" name="status[]" value="0" id="status0" @if(in_array("0", $status)) checked="" @endif>
                                                <label for="status0">
                                                    <small class="badge badge-warning">รออนุมัติ</small>
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline ml-3">
                                                <input type="checkbox" name="status[]" value="1" id="status1" @if(in_array("1", $status)) checked="" @endif>
                                                <label for="status1">
                                                    <small class="badge badge-info">รอรับของ</small>  
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline ml-3">
                                                <input type="checkbox" name="status[]" value="5" id="status5" @if(in_array("5", $status)) checked="" @endif>
                                                <label for="status5">
                                                <small class="badge badge-success">รับของเรียบร้อย</small> 
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline ml-3">
                                                <input type="checkbox" name="status[]" value="4" id="status4" @if(in_array("4", $status)) checked="" @endif>
                                                <label for="status4">
                                                <small class="badge badge-danger">ยกเลิก</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="/po/create/SC">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">สั่งจ้าง ผรม</span>
                                <span class="info-box-number">Create SC</span>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"> ผลการค้นหา </h3>
        <div class="card-tools">

        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>ลำดับ</th>
                    <th>สถานะ</th>
                    <th>ID</th>
                    <th>โครงการ</th>
                    <th>Note</th>
                    <th>ผู้ขาย</th>
                    <th>ยอดรวม</th>
                    <th>วันที่</th>
                    <th>ผู้สร้าง</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $po)
                <tr class="text-center">
                    <td>{{$i +1}}</td>
                    <td>{!!$po->postatus!!}</td>
                    <td><a href="/po/show/{{$po->id}}"> {{$po->code}}</a></td>
                    <td><a href="/project/show/{{$po->project_id}}">  {{$po->project->name}}</a></td>
                    <td>
                        {{$po->note}}
                    </td>
                    <td>{{$po->supplier ? $po->supplier->name : '-'}}</td>
                    <td>{{number_format($po->sum_price + $po->vat_amount, 2)}}</td>

                    <td>{{$po->po_date}}</td>
                    <td>{{$po->user->name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
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
        height: 30px !important;
        padding-top: 3px !important;
        user-select: none;
        -webkit-user-select: none;
    }

    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 8vw;
    }

    .truncate:before{
     content: attr(data-longstring);
    }
</style>
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>

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
    $('#from').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
    })

    $('#to').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
    })

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function load() {
        document.getElementById('btn_submit').style.display = 'none';
        document.getElementById('btn_secondary').style.display = 'block';
        await sleep(2000);
        document.getElementById('btn_submit').style.display = 'block';
        document.getElementById('btn_secondary').style.display = 'none';
    }

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
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    $(function() {
        $('#example1').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection