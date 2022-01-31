@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">ลูกค้า/ซับ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">ลูกค้า/ซับ</li>
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
                    <h3 class="card-title">รายการลูกค้า/ซับ</h3>
                    <div class="card-tools">
                        <a href="/customer/create" type="button"  class="btn btn-block btn-outline-success btn-sm">เพิ่มลูกค้า/ซับ</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table id="example1" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ชื่อ</th>
                                    <th>โทรศัพท์</th>
                                    <th>โทรสาร</th>
                                    <th>ที่อยู่</th>
                                    <th>อีเมลล์</th>
                                    <th>เลขประจำตัวผู้เสียภาษี</th>
                                    <th>สถานะ</th>
                                    <th>note</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                <tr @if($customer->status == 'cancel') bgcolor="#FED1D1" @endif>
                                    <td><a href="/customer/{{$customer->id}}/show">{{$customer->name}}</a></td>
                                    <td>{{$customer->tel}}</td>
                                    <td>{{$customer->fax}}</td>
                                    <td>{{$customer->address}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->txt_tin}}</td>
                                    <td>{{$customer->status}}</td>
                                    <td>{{$customer->note}}</td>
                                    <td>
                                        <a href="/customer/{{$customer->id}}/show"><button type="button" class="btn btn-outline-info btn-sm">จัดการ</button></a>
                                    </td>
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
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
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