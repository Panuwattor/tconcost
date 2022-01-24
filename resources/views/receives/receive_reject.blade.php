@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">รายการรับของ ไม่อนุมัติ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">รายการรับของ รออนุมัติ</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
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
                @foreach($receives as $i => $receive)
                <tr class="text-center">
                <td>{{$i +1}}</td>
                    <td>{!!$receive->receivestatus!!}</td>
                    <td><a href="/revice/show/{{$receive->id}}"> {{$receive->receive_code}}</a></td>
                    <td><a target="_bank" href="/receive/po/show/{{$receive->po->id}}">{{$receive->po->code}}</a></td>
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