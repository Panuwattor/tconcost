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
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Purchase Order</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Purchase Order</h3>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>ลำดับ</th>
                    <th>PO ID</th>
                    <th>โครงการ</th>
                    <th>ผู้ขาย</th>
                    <th>ยอดรวม</th>
                    <th>ประเภท</th>
                    <th>ผู้สร้าง</th>
                    <th>ผู้ไม่อนุมัติ</th>
                    <th>รายละเอียด ไม่อนุมัติ</th>
                    <th>สถานะ</th>
                    <th>รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pos as $i => $po)
                <tr>
                    <td>{{$i +1}}</td>
                    <td><a href="/po/show/{{$po->id}}">{{$po->code}}</a> </td>
                    <td>{{$po->project->name}}</td>
                    <td>{{$po->supplier->name}}</td>
                    <td  class="text-right">{{number_format($po->sum_price + $po->vat_amount, 2)}}</td>
                    <td>{{$po->po_type}}</td>
                    <td><div class="truncate" data-longstring="{{$po->user->name}}"></div></td>
                    <td><div class="truncate" data-longstring="{{$po->approve_user ?$po->approve_user->name : '-'}}"></div> </td>
                    <td><div class="truncate" data-longstring="{{$po->reject_note}}"></div> </td>
                    <td>{!!$po->postatus!!}</td>
                    <td>
                        <a href="/po/show/{{$po->id}}"><button type="button" class="btn btn-block btn-outline-info btn-sm">รายละเอียด</button></a>
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
<style>
    [v-cloak]>* {
        display: none;
    }

    [v-cloak]::before {
        content: " ";
        display: block;
        position: absolute;
        width: 80px;
        height: 80px;
        background-image: url(http://pluspng.com/img-png/loader-png-indicator-loader-spinner-icon-512.png);
        background-size: cover;
        left: 40%;
        top: 40%;
    }

    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 5vw;
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
<!-- DataTables -->
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
      "responsive": true,
    });
  });
</script>

@endsection