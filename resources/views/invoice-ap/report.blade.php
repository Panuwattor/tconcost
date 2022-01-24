@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Invoice AP Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Invoice AP Report</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form role="form">
            <div class="row">
                <div class="col-sm-12">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-3">
                    <select required name="project_id" class="form-control form-control-sm select2">
                        <option value="all" @if($project_id == 'all') selected @endif>ทั้งหมด</option>
                        @foreach($projects as $project)
                        <option value="{{$project->id}}" @if($project->id == $project_id) selected @endif>{{$project->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12 col-md-2">
                            <select name="date_type" class="form-control form-control-sm">
                                <option value="create_date" @if($date_type=='create_date' )selected @endif>วันที่สร้าง</option>
                                <option value="date" @if($date_type=='date' )selected @endif>วันที่ Invoice</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-2">
                            <input readonly type="text" autocomplete="off" class="form-control form-control-sm" name="from" value="{{$from}}" id="from">
                        </div>
                        <div class="col-12 col-md-2">
                            <input readonly type="text" autocomplete="off" class="form-control form-control-sm" name="to" value="{{$to}}" id="to">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <button style="float: right;" class="btn w-auto btn-outline-success "> <i class="fa fa-search"></i> ค้นหา</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table id="example1" class="table table-hover text-nowrap">
        <thead>
                <tr class="text-center">
                    <th>ลำดับ</th>
                    <th>AP ID</th>
                    <th>Receive Code</th>
                    <th>โครงการ</th>
                    <th>ผู้ขาย</th>
                    <th>วันที่</th>
                    <th>ยอดรวม</th>
                    <th>สถานะ</th>
                    <th>ผู้สร้าง</th>
                    <th>ผู้อนุมัติ</th>
                    <th>อนุมัติเวลา</th>
                    <th>รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $invoice)
                <tr class="text-center">
                    <td>{{$i + 1}}</td>
                    <td>{{$invoice->code}}</td>
                    <td>
                        @foreach($invoice->invoice_lists as $invoice_list)
                        <a href="/receive-waiting-approve/show/{{$invoice_list->id}}">{{$invoice_list->receive->receive_code}}</a>
                        @endforeach
                    </td>
                    <td>{{$invoice->project->name}}</td>
                    <td>{{$invoice->supplier->name}}</td>
                    <td>{{$invoice->date}}</td>
                    <td>{{number_format($invoice->tax_base + $invoice->vat, 2)}}</td>
                    <td>{!!$invoice->state!!}</td>
                    <td>{{$invoice->user->name}}</td>
                    <td>
                        @if($invoice->user_approve)
                        {{$invoice->user_approve->name}}
                        @else
                        -
                        @endif
                    </td>
                    <td>{{$invoice->user_approve_time}}</td>
                    <td>
                        <a href="/invoice-ap/show/{{$invoice->id}}"><button type="button" class="w-auto btn btn-outline-info btn-sm">รายละเอียด</button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
            "responsive": false,
        });
    });
</script>
@endsection