@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$type == 'PAD' ? 'รายการเบิกงวดงาน' :'รายการรับของ'}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">{{$type == 'PAD' ? 'รายการเบิกงวดงาน' :'รายการรับของ'}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form role="form">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <select   name="project_id" class="form-control form-control-sm select2" >
                                <option value='all'>ทั้งหมด</option>
                                @foreach($projects as $project)
                                <option value="{{$project->id}}" @if($project->id == $project_id)selected @endif>{{$project->code}} {{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="date_type" class="form-control form-control-sm">
                                    <option value="date" @if($date_type == 'date')selected @endif>วันที่รับของ</option>
                                    <option value="create_date" @if($date_type == 'create_date')selected @endif>วันที่สร้าง</option>    
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input readonly type="text" autocomplete="off" class="form-control form-control-sm" name="from" value="{{$from}}" id="from">
                                </div>
                                <div class="col-md-3">
                                    <input readonly type="text" autocomplete="off" class="form-control form-control-sm" name="to" value="{{$to}}" id="to">
                                </div>
                                <div class="col-md-3">
                                    <button style="float: right;" class="btn w-auto btn-outline-success "> <i class="fa fa-search"></i> ค้นหา</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline ml-3">
                                            <input type="checkbox" name="status[]" value="0" id="status0" @if(in_array("0", $status)) checked="" @endif>
                                            <label for="status0">
                                                <small class="badge badge-info">สร้าง</small>
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline ml-3">
                                            <input type="checkbox" name="status[]" value="2" id="status2" @if(in_array("2", $status)) checked="" @endif>
                                            <label for="status2">
                                                <small class="badge badge-success">อนุมัติ</small>  
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline ml-3">
                                            <input type="checkbox" name="status[]" value="1" id="status1" @if(in_array("1", $status)) checked="" @endif>
                                            <label for="status1">
                                            <small class="badge badge-success">เสร็จสิ้น</small>
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline ml-3">
                                            <input type="checkbox" name="status[]" value="3" id="status3" @if(in_array("3", $status)) checked="" @endif>
                                            <label for="status3">
                                            <small class="badge badge-danger">ไม่อนุมัติ</small> 
                                            </label>
                                        </div>
     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($type == 'PAD')
                <div class="col-md-4">
                    <a href="/receive/select/PAD">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-pie-chart"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">รอเบิกงวดงาน <span class="right badge badge-danger">{{$pos_sc->count()}}</span></span>
                                <span class="info-box-number">Receive PO</span>
                            </div>
                        </div>
                    </a>
                </div>
                @else
                <div class="col-md-4">
                    <a href="/receive/select/RR">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">รอรับของ <span class="right badge badge-danger">{{$pos_po->count()}}</span></span>
                                <span class="info-box-number">Receive PO</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Receive Report</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
        <table id="example1" class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>ลำดับ</th>
                    <th>สถานะ</th>
                    <th>Receive ID</th>
                    <th>PO ID</th>
                    <th>โครงการ</th>
                    <th>note</th>
                    <th>ผู้ขาย</th>
                    <th>ยอดรวม</th>
                    <th>วันที่</th>
                    <th>ผู้รับ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $receive)
                    <tr class="text-center">
                    <td>{{$i +1}}</td>
                    <td>{!!$receive->receivestatus!!}</td>
                    <td><a href="/revice/show/{{$receive->id}}"> {{$receive->receive_code}}</a></td>
                    <td><a target="_bank" href="/po/show/{{$receive->po->id}}">{{$receive->po->code}}</a></td>
                    <td> <a href="/project/show/{{$receive->project_id}}" target="back">{{$receive->project->name}}</a> </td>
                    <td>{{$receive->note}}</td>
                    <td>{{$receive->supplier->name}}</td>
                    <td>{{number_format($receive->receive_lists->sum('price') - $receive->special_discount, 2)}}</td>
                    <td>{{$receive->date}}</td>
                    <td>{{$receive->user->name}}</td>
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
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            
        });
    });
</script>
@endsection