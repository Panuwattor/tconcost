@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Inspection Sheet</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Inspection Sheet</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card card-default">
                <div class="card-body p-0">
                    <form action="/invoice-ar/create" method="POST" id="create_ar">
                        @csrf
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>ลำดับ</th>
                                        <th>Code</th>
                                        <th>ชื่อโครงการ</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>วันที่</th>
                                        <th>ผู้ทำรายการ</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inspections as $i => $inspection)
                                    <tr class="text-center">
                                        <td>{{$i + 1}}</td>
                                        <td>{{$inspection->code}}</td>
                                        <td>{{$inspection->project->name}}</td>
                                        <td>{{$inspection->project->customer->name}}</td>
                                        <td>{{$inspection->date}}</td>
                                        <td>{{$inspection->user->name}}</td>
                                        <td>
                                            <a href="/inspection/show/{{$inspection->id}}"><button type="button" class="btn w-auto btn-outline-success btn-sm">รายละเอียด</button></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
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
        height: 38px !important;
        padding-top: 8px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>
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
        $('.select2').select2({width: '100%'})

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>

<script>
    var inspections = '{!!$inspections!!}';
    inspections = JSON.parse(inspections)

    function select_all() {
        if (document.getElementById('select_all').checked) {
            for (var i = 0; i < inspections.length; i++) {
                document.getElementById('select' + i).checked = true;
            }
        } else {
            for (var i = 0; i < inspections.length; i++) {
                document.getElementById('select' + i).checked = false;
            }
        }
    }

    function submit_ar() {
        document.getElementById('create_ar').submit();
    }
</script>
@endsection