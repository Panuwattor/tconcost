@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">เลือกงวดงาน</h1>
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
                <div class="card-header">
                    <h3 class="card-title">Inspection Sheet</h3>
                </div>
                <div class="card-body">
                    <form action="/inspection/create" method="post">
                        @csrf
                        <input type="hidden" name="project_id" value="{{$project->id}}">
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>
                                            <div class="form-group mb-0">
                                                <div class="custom-control custom-checkbox" onclick="select_all()">
                                                    <input class="custom-control-input" type="checkbox" id="select_all" value="option1">
                                                    <label for="select_all" class="custom-control-label">เลือกทั้งหมด</label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>ลำดับ</th>
                                        <th>Contract</th>
                                        <th>ประเภท</th>
                                        <th>วันที่</th>
                                        <th class="text-left">รายละเอียด</th>
                                        <th>หน่วย</th>
                                        <th>จำนวนเงิน</th>
                                        <th>%</th>
                                        <th>ส่วนลด</th>
                                        <th>ฝาก</th>
                                        <th>หัก</th>
                                        <th>รวม</th>
                                        <th>หมายเหตุ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->interim->interims_list as $i => $interim_list)
                                    @if($interim_list->status == 0)
                                    <tr class="text-center">
                                        <td>
                                            <div class="form-group mb-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="select{{$i}}" name="interim_list[]" value="{{$interim_list->id}}">
                                                    <label for="select{{$i}}" class="custom-control-label">เลือก</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle; padding: 0px 0px 0px 10px; top: 50%;">{{$i + 1}}</td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;">{{$interim_list->contract}}</td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;">{{$interim_list->type}}</td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;">{{$interim_list->date}}</td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;" class="text-left"><div class="truncate" data-longstring="{{$interim_list->description}}"></div> </td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;">{{$interim_list->unit}}</td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;">{{number_format($interim_list->price, 2)}}</td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;">{{$interim_list->percent}}</td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;">{{number_format($interim_list->discount, 2)}}</td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;">{{number_format($interim_list->deposit, 2)}}</td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;">{{number_format($interim_list->retention, 2)}}</td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;">{{number_format($interim_list->total, 2)}}</td>
                                        <td style="padding: 0px 0px 0px 10px; vertical-align: middle;">{{$interim_list->remark}}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" style="float: right;" class="btn w-auto btn-outline-success btn-sm">ต่อไป</button>
                            </div>
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

    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 10vw;
    }

    .truncate:before{
     content: attr(data-longstring);
    }

    .truncate:hover::before {
        content: attr(data-longstring);
        width: auto;
        height: auto;
        overflow: initial;
        text-overflow: initial;
        white-space: initial;
        background-color: white;
        display: inline-block;
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
    var interims = '{!!$project->interim->interims_list!!}';
    interims = JSON.parse(interims)

    function select_all() {
        if (document.getElementById('select_all').checked) {
            for (var i = 0; i < interims.length; i++) {
                if (interims[i].status == 0) {
                    document.getElementById('select' + i).checked = true;
                }
            }
        } else {
            for (var i = 0; i < interims.length; i++) {
                if (interims[i].status == 0) {
                    document.getElementById('select' + i).checked = false;
                }
            }
        }
    }
</script>
@endsection