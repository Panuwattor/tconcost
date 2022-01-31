@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">รับของ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/receive/report/{{$receive}}">รายการ</a></li>
                    <li class="breadcrumb-item active">รับของ</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">รับของ</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive">
        <table id="example1"  class="table table-hover text-nowrap" style="font-size: 10pt;">
            <thead>
                <tr class="text-center">
                    <th>ลำดับ</th>
                    <th>โครงการ</th>
                    <th>PO ID</th>
                    <th>supplier</th>
                    <th>Amount</th>
                    <th>ประเภท</th>
                    <th>วันที่ขอ</th>
                    <th>ผู้สร้าง</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pos as $i => $po)
                <tr class="text-center">
                    <td>{{$i +1}}</td>
                    <td>{{$po->project->name}}</td>
                    <td><a target="_bank" href="/receive/po/show/{{$po->id}}">{{$po->po_id}}</a></td>
                    <td>{{$po->supplier->name}}</td>
                    <td>{{number_format($po->vat_amount + $po->sum_price, 2)}}/{{number_format($po->receiveRemain, 2)}}</td>
                    <td>{{$po->po_type}}</td>
                    <td>{{$po->po_date}}</td>
                    <td>{{$po->user->name}}</td>
                    <td>
                        <a href="/receive/po/{{$po->id}}/{{$receive}}"><button type="button" class="btn btn-outline-info btn-sm">รับของ</button></a>
                        &nbsp;&nbsp;
                        <a href="/receive/po/close/{{$po->id}}/{{$receive}}"><button type="button" class="btn btn-outline-danger btn-xs">ปิดการรับของ</button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
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