@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">หัก ณ ที่จ่าย</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">หัก ณ ที่จ่าย</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card" id="app">
    <div class="card-header">
        <h3 class="card-title">หัก ณ ที่จ่าย {!!$wht->state!!}</h3>
        <div class="card-tools">
            <form action="/wht/print/{{$wht->id}}" method="get">
                @if($wht->status == 0)
                <a href="/wht/edit/{{$wht->id}}"><button type="button" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i>แก้ไข</button></a>
                @endif
                <button type="submit" class="btn btn-outline-secondary btn-sm">พิมพ์</button>
                <select name="brach_id" class="form-control form-control-sm">
                    @foreach($branchs as $branch)
                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="card-body table-responsive">
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>ผู้ขาย</label>
                    <br>
                    <span class="text-secondary">{{$wht->supplier->name}}</span>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>Code</label>
                    <br><span class="text-secondary">{{$wht->code}}</span>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>ประเภท</label>
                    <br><span class="text-secondary">{{$wht->type}}</span>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>ผู้จ่ายเงิน</label>
                    <br><span class="text-secondary">{{$wht->wht_payment_type}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>วันที่</label>
                    <br><span class="text-secondary">{{$wht->date}}</span>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>ชื่อ</label>
                    <br><span class="text-secondary">{{$wht->name}}</span>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>Tax Id</label>
                    <br><span class="text-secondary">{{$wht->tax_id}}</span>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>Address</label>
                    <br><span class="text-secondary">{{$wht->address}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>ลักษณะการยื่น</label>
                    <br><span class="text-secondary">{{$wht->attribute}}</span>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>ระบุ</label>
                    <br><span class="text-secondary">{{$wht->note}}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Type</th>
                            <th>Article</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Rate</th>
                            <th>WHT TAX</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wht->wht_lists as $i => $wht_list)
                        <tr class="text-center">
                            <td>{{$i + 1}}</td>
                            <td>@if($wht_list->group){{$wht_list->group->name}} ({{$wht_list->group->percent}})@endif</td>
                            <td>{{$wht_list->article}}</td>
                            <td>{{$wht_list->note}}</td>
                            <td>{{$wht_list->amount}}</td>
                            <td>{{$wht_list->rate}}</td>
                            <td>{{$wht_list->wht_tax}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-4"></div>
        <div class="col-4"></div>
        <div class="col-4">
            <form action="/delete/wht/{{$wht->id}}" method="post" onsubmit="return confirm('ยืนยัน ?')">
                @csrf
                <button type="submit" class="btn btn-block btn-outline-danger btn-sm">ลบ</button>
            </form>
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
        $('.select2').select2({
            width: '100%'
        })

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