@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">สาขา</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">สาขา</li>
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
                    <h3 class="card-title">รายการสาขา</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-block btn-outline-success btn-sm" data-toggle="modal" data-target="#modal-add">เพิ่มสาขา</button>
                    </div>
                    <div class="modal fade" id="modal-add">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">เพิ่มสาขา</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/branch" method="post"  enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <span for="inputEmail3">สาขา</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ สาขา">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">code สาขา</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="code" name="code" placeholder="รหัสสาขา">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">บริษัท</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="company" name="company" placeholder="บริษัท">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">บริษัท Eng</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="company_eng" name="company_eng" placeholder="บริษัท Eng">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">Logo</span>
                                                    <div>
                                                        <input type="file" class="form-control" name="logo" multiple>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">โทร</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="inputEmail3" name="tel" placeholder="โทรศัพท์">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">เลขประจำตัวผู้เสียภาษี</span>
                                                    <div>
                                                        <input type="text" class="form-control" id="inputEmail3" name="tax" placeholder="เลขประจำตัวผู้เสียภาษี">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">รหัส สาขา ประจำตัวผู้เสียภาษี</span>
                                                    <div>
                                                        <input type="text" class="form-control" id="tax_code" name="tax_code" placeholder="รหัส สาขา เลขประจำตัวผู้เสียภาษี">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <span for="inputEmail3">ที่อยู่</span>
                                                    <div>
                                                        <textarea required class="form-control" rows="3" name="address" placeholder="Enter ..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">สถานะ</span>
                                                    <div>
                                                        <select class="form-control" name="status">
                                                            <option value="0">ยกเลิก</option>
                                                            <option value="1">ใช้งาน</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">note</span>
                                                    <div>
                                                        <textarea class="form-control" rows="3" name="note" placeholder="Enter ..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table id="example1" class="table table-hover text-nowrap">
                            <thead>
                                <tr  class="text-center">
                                    <th>logo</th>
                                    <th>ชื่อ</th>
                                    <th>บริษัท</th>
                                    <th>โทรศัพท์</th>
                                    <th>ที่อยู่</th>
                                    <th>เลขประจำตัวผู้เสียภาษี</th>
                                    <th>note</th>
                                    <th>สถานะ</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($branchs as $branch)
                                <tr class="text-center">
                                    <td> @if($branch->logo) <img src="/storage/{{ $branch->logo }}" width="50px" height="50px" class="img-circle elevation-2" alt="User Image">@endif</td>
                                    <td>{{$branch->code}} {{$branch->name}}</td>
                                    <td>{{$branch->company}} </br> <small> {{$branch->company_eng}} </small> </td>

                                    <td>{{$branch->tel}}</td>
                                    <td>{{$branch->address}}</td>
                                    <td>{{$branch->tax}} </br> <small>( {{$branch->tax_code}} )</small></td>
                                    <td>{{$branch->note}}</td>
                                    <td>{{$branch->status}}</td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-outline-warning btn-sm" data-toggle="modal" data-target="#modal-edit{{$branch->id}}">แก้ไข</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @foreach($branchs as $branch)
                    <div class="modal fade" id="modal-edit{{$branch->id}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">เพิ่มสาขา</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/branch/update/{{$branch->id}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <span for="inputEmail3">สาขา</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ สาขา" value="{{$branch->name}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">code สาขา</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="code" name="code" placeholder="รหัสสาขา" value="{{$branch->code}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">บริษัท</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="company" name="company" placeholder="บริษัท" value="{{$branch->company}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">บริษัท Eng</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="company_eng" name="company_eng" placeholder="บริษัท Eng" value="{{$branch->company_eng}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">Logo</span>
                                                    <div>
                                                        <input type="file" class="form-control" name="logo" multiple>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">โทร</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="inputEmail3" name="tel" placeholder="โทรศัพท์" value="{{$branch->tel}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">เลขประจำตัวผู้เสียภาษี</span>
                                                    <div>
                                                        <input type="text" class="form-control" id="inputEmail3" name="tax" placeholder="เลขประจำตัวผู้เสียภาษี" value="{{$branch->tax}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">รหัส สาขา ประจำตัวผู้เสียภาษี</span>
                                                    <div>
                                                        <input type="text" class="form-control" id="tax_code" name="tax_code" placeholder="รหัส สาขา เลขประจำตัวผู้เสียภาษี" value="{{$branch->tax_code}}">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <span for="inputEmail3">ที่อยู่</span>
                                                    <div>
                                                        <textarea required class="form-control" rows="3" name="address" placeholder="Enter ...">{{$branch->address}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">สถานะ</span>
                                                    <div>
                                                        <select class="form-control" name="status">
                                                            <option value="0" @if($branch->status == 0) selected @endif>ยกเลิก</option>
                                                            <option value="1" @if($branch->status == 1) selected @endif>ใช้งาน</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">note</span>
                                                    <div>
                                                        <textarea class="form-control" rows="3" name="note" placeholder="Enter ...">{{$branch->note}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    @endforeach
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
      "searching": false,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endsection