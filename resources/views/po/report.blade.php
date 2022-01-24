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
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Purchase Order</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form role="form" action="/po/report">
            @csrf
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <div class="form-group clearfix mr-3">
                                <div class="icheck-primary d-inline ml-3">
                                    <input type="checkbox" name="types[]" value="PO" id="checkboxPrimary1" @if(in_array("PO", $types)) checked="" @endif>
                                    <label for="checkboxPrimary1">
                                        PO
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline ml-3">
                                    <input type="checkbox" name="types[]" value="PS" id="checkboxPrimary2" @if(in_array("PS", $types)) checked="" @endif>
                                    <label for="checkboxPrimary2">
                                        PS
                                    </label>
                                </div>
                                <div class="icheck-primary d-inline ml-3">
                                    <input type="checkbox" name="types[]" value="SC" id="checkboxPrimary3" @if(in_array("SC", $types)) checked="" @endif>
                                    <label for="checkboxPrimary3">
                                        SC
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row">
                    <div class="col-12 col-md-3 my-1">
                        <select required name="project_id" class="form-control form-control-sm select2" id="">
                            <option value="all">ทั้งหมด</option>
                            @foreach($projects as $project)
                            <option value="{{$project->id}}" @if($project->id == $project_id) selected @endif >{{$project->code}} {{$project->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-1 my-1">
                        <button style="float: right;" class="btn-sm w-auto btn-outline-success "> <i class="fa fa-search"></i> ค้นหา</button>
                    </div>
                </div>
        </form>
    </div>

</div>




<div class="card">
    <div class="card-header">
        <h3 class="card-title">Reports Purchase Order</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>ลำดับ</th>
                    <th>โครงการ</th>
                    <th>PO ID</th>
                    <th>ผู้ขาย</th>
                    <th>ยอดรวม</th>
                    <th>Note</th>
                    <th>ผู้สร้าง</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pos as $i => $po)
                <tr class="text-center">
                    <td>{{$i +1}}</td>
                    <td>{{$po->project ? $po->project->name : '-'}}</td>
                    <td><a href="/po/show/{{$po->id}}">{{$po->code}}</a></td>
                    <td>{{$po->supplier ? $po->supplier->name : '-'}}</td>
                    <td>{{number_format($po->sum_price + $po->vat_amount, 2)}}</td>
                    <td>
                        <div class="truncate" data-toggle="dropdown" > {{$po->note}}
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item">{{$po->note}}</a>
                            </div>
                        </div>
                    </td>
                    <td>{{$po->user->name}}</td>
                    <td>{!!$po->postatus!!}</td>
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
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection