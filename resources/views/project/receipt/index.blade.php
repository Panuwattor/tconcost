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
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="date" autocomplete="off" class="form-control form-control-sm" name="from" value="{{$from}}" id="from">
                            </div>
                            <div class="col-md-4">
                                <input type="date" autocomplete="off" class="form-control form-control-sm" name="to" value="{{$to}}" id="to">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-block btn-outline-success"><i class="fa fa-search"></i> ค้นหา</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3>ใบเสร็จรับเงิน</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table class="table table-hover text-nowrap" id="example1">
                            <thead>
                                <tr class="text-center">
                                    <th>ลำดับ</th>
                                    <th>Code</th>
                                    <th>โครงการ</th>
                                    <th>วันที่</th>
                                    <th class="text-right">Remain</th>
                                    <th class="text-right">Receipt Amount</th>
                                    <th>Note</th>
                                    <th>ผู้ทำรายการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receipt_ars as $i => $receipt_ar)
                                <tr>
                                    <td class="text-center">{{$i + 1}}</td>
                                    <td class="text-left">
                                        @if($receipt_ar->status == 99)
                                        <a href="/receipt-ar/show/{{$receipt_ar->id}}" class="text-danger">{{$receipt_ar->code}} <small> (ยกเลิก) </small></a>
                                        @else
                                        <a href="/receipt-ar/show/{{$receipt_ar->id}}">{{$receipt_ar->code}}</a>
                                        @endif
                                    </td>
                                    <td class="text-left"><a href="/project/show/{{$receipt_ar->project_id}}">{{$receipt_ar->project->name}}</a></td>
                                    <td class="text-center">{{$receipt_ar->date}}</td>
                                    <td class="text-right">{{number_format($receipt_ar->remain, 2)}}</td>
                                    <td class="text-right">{{number_format($receipt_ar->receipt_amount, 2)}}</td>
                                    <td class="text-center">{{$receipt_ar->note}}</td>
                                    <td class="text-center">{{$receipt_ar->user->name}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('header')
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection
@section('footer')
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
<script>
    $(function() {
        var a = "{{auth()->user()->branch->name}}";
        $('#example1').DataTable({
            dom: 'Bfrtip',
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": false,
            buttons: [{
                extend: 'excel',
                filename: 'ใบเสร็จรับเงิน ' + a,
                title: 'รายงาน ใบเสร็จรับเงิน'
            }, ]
        });
    });
</script>
@endsection