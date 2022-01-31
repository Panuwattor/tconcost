@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">บริษัท</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">บริษัท</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <a href="#" data-toggle="modal" data-target="#modal-create-branch">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-home"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">เพิ่มบริษัท</span>
                        <span class="info-box-number">
                            <small>Create Company</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        </div>
        <div class="modal fade" id="modal-create-branch">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">เพิ่มบริษัท</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/user/to/branch" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <span for="inputEmail3">บริษัท</span>
                                        <div>
                                            <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ บริษัท">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <span for="inputEmail3">code บริษัท</span>
                                        <div>
                                            <input required type="text" class="form-control" id="code" name="code" placeholder="รหัสบริษัท">
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
                                        <span for="inputEmail3">รหัส บริษัท ประจำตัวผู้เสียภาษี</span>
                                        <div>
                                            <input type="text" class="form-control" id="tax_code" name="tax_code" placeholder="รหัส บริษัท เลขประจำตัวผู้เสียภาษี">
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
                                                <option value="1">ใช้งาน</option>
                                                <option value="0">ยกเลิก</option>
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
        <div class="col-12 col-sm-6 col-md-3">
            <a href="#" data-toggle="modal" data-target="#addUserModal">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">เพิ่มพนักงาน</span>
                        <span class="info-box-number">New User</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </a>
        </div>
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-edit"></i> เพิ่ม User </h5>
                    </div>
                    <form method="post" class="form-horizontal" action="/user/to/branch/register" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-control-label">ภาพ <code>สี่เหลี่ยมจัตุรัส</code></label>
                                <div class="col-sm-12">
                                    <input type="file" class="form-control" name="photo" multiple>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-control-label">ชื่อ</label>
                                <div class="col-sm-12">
                                    <input type="text" placeholder="ชื่อ" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-control-label">เบอร์</label>
                                <div class="col-sm-12">
                                    <input type="text" placeholder="เบอร์" class="form-control" name="phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-control-label">Email</label>
                                <div class="col-sm-12">
                                    <input type="email" placeholder="Email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-control-label">Password</label>
                                <div class="col-sm-12">
                                    <input type="text" placeholder="Password" class="form-control" name="password" minlength="4" maxlength="20">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>สถานะ</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="status">
                                        <option value="1">ใช้งาน</option>
                                        <option value="0">ยกเลิก</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <h4>บริษัท</h4>
                                <div class="row">
                                    @foreach($to_branchs as $to_branch)
                                    <div class="form-group col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="to_branchs[]" value="{{$to_branch->branch_id}} " checked> {{$to_branch->branch->code}} <small>{{$to_branch->branch->name}}</small>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <a href="#" data-toggle="modal" data-target="#SelectCompanyModal">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-hand-pointer-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">เลือกบริษัท</span>
                        <span class="info-box-number">Select Company</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </a>
        </div>
        <div class="modal fade" id="SelectCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header  bg-warning">
                        <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-hand-pointer-o"></i> เลือกบริษัท Select Company</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        @foreach(auth()->user()->to_branchs as $to_branch)
                        <a href="/auth/user/checkout/tobranch/{{$to_branch->id}}" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                @if($to_branch->branch->logo)
                                <img src="{{ Storage::disk('spaces')->url($to_branch->branch->logo) }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                @else
                                <img src="/home.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                @endif
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        @if($to_branch->branch_id == auth()->user()->branch_id)<span class="float-right text-sm text-danger"><i class="fas fa-star"></i>@else <span class="float-right text-sm"> <i class="fa fa-star-o"></i>@endif</span>
                                    </h3>
                                    <p class="text-sm">{{$to_branch->branch->company}}</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{$to_branch->branch->company_eng}}</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-12 col-12">
            @foreach($to_branchs as $to_branch)
            <div class="card card-default ">
                <div class="card-header">
                    <div class="card-tools">
                        <button type="button" class="btn btn-block btn-outline-success btn-sm" data-toggle="modal" data-target="#modal-createUserToBranch{{$to_branch->id}}"><i class="fas fa-user"></i> ผูกพนักงาน</button>
                    </div>
                    <div class="modal fade" id="modal-createUserToBranch{{$to_branch->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fas fa-user"></i> ผูกพนักงาน</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/user/to/branch/merge/{{$to_branch->branch->id}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <span for="inputEmail3">Email</span>
                                            <div>
                                                <input required type="email" class="form-control" id="inputEmail3" name="email" placeholder="email" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">สิทธิ์์</span>
                                            <div>
                                                <select class="form-control" name="status">
                                                    <option value="1">admin</option>
                                                    <option value="2">write</option>
                                                    <option value="3">read</option>
                                                </select>
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
                    <h3>
                        @if($to_branch->branch->logo) <img src="{{ Storage::disk('spaces')->url($to_branch->branch->logo) }}" width="50px" height="50px" class="img-circle elevation-2" alt="User Image">@endif
                        {{$to_branch->branch->code}} {{$to_branch->branch->name}}
                    </h3>
                    <h6>
                        {{$to_branch->branch->address}}
                    </h6>
                    <table id="example1" class="table  table-hover  text-nowrap ">
                        <thead>
                            <tr class="text-center">
                                <th>บริษัท</th>
                                <th>โทรศัพท์</th>
                                <th>เลขประจำตัวผู้เสียภาษี</th>
                                <th>สถานะ</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>{{$to_branch->branch->company}} </br> <small> {{$to_branch->branch->company_eng}} </small> </td>
                                <td>{{$to_branch->branch->tel}}</td>
                                <td>{{$to_branch->branch->tax}} </br> <small>( {{$to_branch->branch->tax_code}} )</small></td>
                                <td>{{$to_branch->branch->status == 1 ? 'ใช้งาน' : 'ยกเลิก'}}</td>
                                <td>
                                    <button type="button" class="btn btn-block btn-outline-warning btn-sm" data-toggle="modal" data-target="#modal-edit{{$to_branch->branch->id}}">แก้ไข</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">

                    <table id="example2" class="table table-bordered text-nowrap table-sm">
                        <thead>
                            <tr class="text-center">
                                <th>ผู้ที่อยู่ในสาขา</th>
                                <th>email</th>
                                <th>สถานะ</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($to_branch->branch->to_users as $to_users)
                            <tr class="text-center">
                                <td>{{$to_users->user->name}} </small> </td>
                                <td>{{$to_users->user->email}}</td>
                                <td>@if($to_users->status == 1) Admin @elseif($to_users->status == 2) Write @else Read @endif</td>
                                <td>
                                    <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#modal-editToBranch{{$to_users->id}}"><i class="fa fa-pencil-square-o"></i> จัดการ</button>
                                </td>
                            </tr>
                            <div class="modal fade" id="modal-editToBranch{{$to_users->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><i class="fa fa-pencil-square-o"></i> จัดการ</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="/user/to/branch/manage/usertobranch/{{$to_users->id}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <h3 for="inputEmail3">{{$to_users->user->name}}</h3>
                                                    <h3 for="inputEmail3">{{$to_users->user->email}}</h3>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">สิทธิ์์</span>
                                                    <div>
                                                        <select class="form-control" name="status">
                                                            <option value="1" {{$to_users->status == 1 ? 'selected' : ''}}>admin</option>
                                                            <option value="2" {{$to_users->status == 2 ? 'selected' : ''}}>write</option>
                                                            <option value="3" {{$to_users->status == 3 ? 'selected' : ''}}>read</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" value="1" name="type" class="btn btn-danger">นำชื่อออก</button>
                                                <button type="submit" value="2" name="type" class="btn btn-success">ยืนยันแก้ไข</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="modal-edit{{$to_branch->branch->id}}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">แก้ไขบริษัท</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/branch/update/{{$to_branch->branch->id}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <span for="inputEmail3">บริษัท</span>
                                            <div>
                                                <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ บริษัท" value="{{$to_branch->branch->name}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">code บริษัท</span>
                                            <div>
                                                <input required type="text" class="form-control" id="code" name="code" placeholder="รหัสบริษัท" value="{{$to_branch->branch->code}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">บริษัท</span>
                                            <div>
                                                <input required type="text" class="form-control" id="company" name="company" placeholder="บริษัท" value="{{$to_branch->branch->company}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">บริษัท Eng</span>
                                            <div>
                                                <input required type="text" class="form-control" id="company_eng" name="company_eng" placeholder="บริษัท Eng" value="{{$to_branch->branch->company_eng}}">
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
                                                <input required type="text" class="form-control" id="inputEmail3" name="tel" placeholder="โทรศัพท์" value="{{$to_branch->branch->tel}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">เลขประจำตัวผู้เสียภาษี</span>
                                            <div>
                                                <input type="text" class="form-control" id="inputEmail3" name="tax" placeholder="เลขประจำตัวผู้เสียภาษี" value="{{$to_branch->branch->tax}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">รหัส บริษัท ประจำตัวผู้เสียภาษี</span>
                                            <div>
                                                <input type="text" class="form-control" id="tax_code" name="tax_code" placeholder="รหัส บริษัท เลขประจำตัวผู้เสียภาษี" value="{{$to_branch->branch->tax_code}}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <span for="inputEmail3">ที่อยู่</span>
                                            <div>
                                                <textarea required class="form-control" rows="3" name="address" placeholder="Enter ...">{{$to_branch->branch->address}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">สถานะ</span>
                                            <div>
                                                <select class="form-control" name="status">
                                                    <option value="0" @if($to_branch->branch->status == 0) selected @endif>ยกเลิก</option>
                                                    <option value="1" @if($to_branch->branch->status == 1) selected @endif>ใช้งาน</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <span for="inputEmail3">note</span>
                                            <div>
                                                <textarea class="form-control" rows="3" name="note" placeholder="Enter ...">{{$to_branch->branch->note}}</textarea>
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
@endsection


@section('header')
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection

@section('footer')
@if(!auth()->user()->branch_id)
<script>
$(function() {
    $('#SelectCompanyModal').modal('show');
});
</script>
@endif
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
    $(function() {
        $('#example1').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
        $('#example2').DataTable({
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