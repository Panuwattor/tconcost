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
    <div class="card-header">
        <h3 class="card-title">Purchase Order</h3>

        <div class="card-tools">
            <a href="/po/create/NR"><button type="button" class="btn btn-block btn-outline-info btn-sm">สั่งซื้อ</button></a>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table  id="example1" class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>ลำดับ</th>
                    <th>โครงการ</th>
                    <th>PO ID</th>
                    <th>ผู้ขาย</th>
                    <th>ยอดรวม</th>
                    <th>ประเภท</th>
                    <th>ผู้สร้าง</th>
                    <th>สถานะ</th>
                    <th>รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pos as $i => $po)
                <tr class="text-center">
                    <td>{{$i +1}}</td>
                    <td>{{$po->project->name}}</td>
                    <td>{{$po->code}}</td>
                    <td>{{$po->supplier->name}}</td>
                    <td>{{number_format($po->sum_price + $po->vat_amount, 2)}}</td>
                    <td>{{$po->po_type}}</td>
                    <td>{{$po->user->name}}</td>
                    <td>{!!$po->postatus!!}</td>
                    <td>
                        <a href="/po-nr/show/{{$po->id}}"><button type="button" class="btn btn-outline-info btn-xs">รายละเอียด</button></a>
                        <button type="button" class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#modal-action{{$po->id}}">Action</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @foreach($pos as $i => $po)
    <div class="modal fade" id="modal-action{{$po->id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Actions</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <a class="btn btn-app bg-danger" onclick="cancle('{{$po->id}}')">
                    <i class="fas fa-close"></i> ยกเลิก
                    </a>
                    <a class="btn btn-app bg-warning" onclick="edit('{{$po->id}}')">
                    <i class="fa fa-book"></i> แก้ไข
                    </a>
                    <a class="btn btn-app bg-success" onclick="sentApprove('{{$po->id}}')">
                    <i class="fa fa-book"></i> ขออนุมัติ
                    </a>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
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
<script>
    function sentApprove(id) {
        if (confirm('ยืนยัน ขออนุมัติ PO ?')) {
            location.href = "/po-nr/sent/" + id;
        }
    }
    
    function edit(id) {
        if (confirm('ยืนยัน แก้ไข PO ?')) {
            location.href = "/po-nr/edit/" + id;
        }
    }

    function cancle(id) {
        if (confirm('ยืนยัน ยกเลิก PO ?')) {
            location.href = "/po-nr/cancle/" + id;
        }
    }
</script>
@endsection