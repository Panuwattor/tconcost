@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Receipt AR</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Receipt AR</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card card-default">
                <div class="card-header">
                    <form action="/receipt-ar/finish" method="get">
                        @csrf
                        <div class="row">
                        @foreach($branchs as $i => $branch)
                            <div class="col-md-2 col-4">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="{{$branch->id}}" value="{{$branch->id}}" name="branchs_select[]" @if(in_array("$branch->id", $branchs_select)) checked="" @endif>
                                    <label for="{{$branch->id}}" class="custom-control-label">{{$branch->name}}</label>
                                </div>
                                &nbsp;&nbsp;&nbsp;
                            </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-6">
                                <select class="form-control" name="project_id" id="">
                                    <option value="all">ทั้งหมด</option>
                                    @foreach($projects as $project)
                                    <option value="{{$project->id}}" @if($project->id == $project_id)selected @endif>{{$project->id}} : {{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-6">
                                <input class="form-control" type="date" name="from" id="from" value="{{$from}}">
                            </div>
                            <div class="col-md-3 col-6">
                                <input class="form-control" type="date" name="to" id="to" value="{{$to}}">
                            </div>
                            <div class="col-md-3 col-6">
                                <button type="submit" class="btn btn-success">ค้นหา</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <form action="/receipt-voucher/create" method="post" id="receipt_voucher">
                        @csrf
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>ลำดับ</th>
                                        <th>Code</th>
                                        <th>AR</th>
                                        <th>โครงการ</th>
                                        <th>วันที่</th>
                                        <!-- <th class="text-right">Amount</th> -->
                                        <th class="text-right">Remain</th>
                                        <th class="text-right">Receipt Amount</th>
                                        <th>ผู้ทำรายการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($receipt_ars as $i => $receipt_ar)
                                    <tr class="text-center">
                                        <td>{{$i + 1}}</td>
                                        <td><a href="/receipt-ar/show/{{$receipt_ar->id}}">{{$receipt_ar->code}}</a></td>
                                        <td>
                                            <?php
                                            $ar_codes = array();
                                            $ar_ids = array();
                                            foreach ($receipt_ar->receipt_ar_list as $receipt_ar_list) {
                                                array_push($ar_codes, $receipt_ar_list->ar->code);
                                                array_push($ar_ids, $receipt_ar_list->ar->id);
                                            }

                                            $ar_codes = array_unique($ar_codes);
                                            $ar_ids = array_unique($ar_ids);

                                            foreach ($ar_codes as $x => $ar_code) {
                                                echo '<a href="/invoice/show/' . $ar_ids[$x] . '">' . $ar_code . '</a>';
                                                if (sizeof($ar_codes) - 1 != $x) {
                                                    echo ', ';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>{{$receipt_ar->project->name}}</td>
                                        <td>{{$receipt_ar->date}}</td>
                                        <!-- <td class="text-right">{{number_format($receipt_ar->amount, 2)}}</td> -->
                                        <td class="text-right">{{number_format($receipt_ar->remain, 2)}}</td>
                                        <td class="text-right">{{number_format($receipt_ar->receipt_amount, 2)}}</td>
                                        <td>{{$receipt_ar->user->name}}</td>
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

    $('#date').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
    })
</script>
@endsection