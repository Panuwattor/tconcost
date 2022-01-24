@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">ใบแจ้งหนี้ </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">ใบแจ้งหนี้</li>
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
                    <h3 class="card-title">
                        <button type="button" class="btn btn-block btn-outline-info btn-sm" onclick="submit_ar()">Create Receipt</button>
                    </h3>
                    <div class="card-tools">
                    <a href="/project/invoices?status=all" class="btn btn-tool btn-sm">
                        <i class="fas fa-bars"></i> ดูรายการทั้งหมด
                    </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="/receipt-ar/create" method="POST" id="receipt_ar">
                        @csrf
                        <div class="table-responsive">
                            <table id="example1"  class="table table-hover text-nowrap">
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
                                        <th>AR Code</th>
                                        <th>ชื่อโครงการ</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>วันที่</th>
                                        <th>ผู้ทำรายการ</th>
                                        <th>ยอดรวม</th>
                                        <th>ค้างชำระ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoices as $i => $invoice)
                                    <tr class="text-center">
                                        <td>
                                            @if($invoice->status == 0)
                                            <div class="form-group mb-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="select{{$i}}" name="invoices[]" value="{{$invoice->id}}">
                                                    <label for="select{{$i}}" class="custom-control-label"> {{$i + 1}} เลือก</label>
                                                </div>
                                            </div>
                                            @else
                                                @foreach($invoice->ar_lists as $key=>$ar_list)
                                                @if($key > 0) , @endif<a href="/receipt-ar/show/{{$ar_list->receipt_ar_id}}">{{$ar_list->receipt_ar ? $ar_list->receipt_ar->code : '-'}}</a>  
                                                @endforeach
                                            @endif
                                        </td>
                                        <td><a href="/project/invoice/show/{{$invoice->id}}"> {{$invoice->code}}</a></td>
                                        <td><a href="/project/show/{{$invoice->project_id}}">  {{$invoice->project->name}}</a></td>
                                        <td>{{$invoice->project->customer->name}}</td>
                                        <td>{{$invoice->date}}</td>
                                        <td>{{$invoice->user->name}}</td>
                                        <td>
                                          {{ number_format($invoice->total,2)}}
                                        </td>
                                        <td>
                                            {{ number_format($invoice->sumOverdue,2)}}  
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
        $('.select2').select2({width: '100%'})

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>

<script>
    var invoices = '{!!$invoices!!}';
    invoices = JSON.parse(invoices)

    function select_all() {
        if (document.getElementById('select_all').checked) {
            for (var i = 0; i < invoices.length; i++) {
                document.getElementById('select' + i).checked = true;
            }
        } else {
            for (var i = 0; i < invoices.length; i++) {
                document.getElementById('select' + i).checked = false;
            }
        }
    }

    function submit_ar(){
        document.getElementById('receipt_ar').submit();
    }
</script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $(function () {
    $('#example1').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": false,
    });
  });
</script>
@endsection