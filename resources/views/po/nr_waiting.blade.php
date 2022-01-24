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
    <div class="card-body table-responsive">
        <table id="example1"  class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>ลำดับ</th>
                    <th>โครงการ</th>
                    <th>PO ID</th>
                    <th>ผู้ขาย</th>
                    <th>ยอดรวม</th>
                    <th>ประเภท</th>
                    <th>ผู้สร้าง</th>
                    <th class="bg-warning">อนุมัติ</th>
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
                    <td>
                        @if($po->approve_user)
                        {{$po->approve_user->name}}
                        @else
                        -
                        @endif
                    </td>
                    <td>{!!$po->postatus!!}</td>
                    <td>
                        <a href="/po/show/new-approve/{{$po->id}}"><button type="button" class="btn btn-outline-info btn-xs">รายละเอียด</button></a>
                        <!-- <button type="button" class="btn btn-outline-success" onclick="approve('{{$po->id}}')">อนุมัติ</button>
                        <button type="button" class="btn btn-outline-danger btn-xs" data-toggle="modal" data-target="#modal-default">ไม่อนุมัติ</button> -->
                    </td>
                </tr>

                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">รายละเอียด</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea name="reject_note" id="reject_note" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="reject('{{$po->id}}')">ไม่อนุมัติ</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
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
    function approve(id) {
        if (confirm('ต้องการอนุมัติ ?')) {
            location.href = '/po/approve/' + id;
        }
    }

    function reject(id) {
        var reject_note = document.getElementById('reject_note').value;
        if(!reject_note){
            alert('กรอกข้อมูลให้ครบถ้วน');
            return;
        }
        if (confirm('ไม่อนุมัติ ?')) {
            location.href = '/po/reject/' + id + '/' + reject_note;
        }
    }
</script>
@endsection