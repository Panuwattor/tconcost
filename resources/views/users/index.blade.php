@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">ข้อมูลส่วนตัว</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">ข้อมูลส่วนตัว</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลส่วนตัว</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ชื่อ</label>
                        <div class="col-sm-8">
                            <form id="update-name" action="/aboutme/name/{{auth()->user()->id}}" method="POST">
                                @csrf
                                <input type="text" class="form-control" id="name" name="name" value="{{auth()->user()->name}}">
                            </form>
                        </div>
                        <div class="col-sm-2">
                            <label style="float: right; cursor: pointer;" class="col-form-label text-info" onclick="event.preventDefault(); document.getElementById('update-name').submit();">อัพเดท</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input readonly type="email" class="form-control" id="email" value="{{auth()->user()->email}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">รูปภาพ</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <form id="update-photo" action="/aboutme/photo/{{auth()->user()->id}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" class="custom-file-input" name="photo" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </form>
                                    </div>
                                    <div class="input-group-append">
                                        <span style="cursor: pointer;" class="input-group-text" id="" onclick="event.preventDefault(); document.getElementById('update-photo').submit();">Upload</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            @if(auth()->user()->photo)
                            <img src="{{ Storage::disk('spaces')->url(auth()->user()->photo) }}" alt="User Avatar" width="25%" class="img-circle">
                            @else
                            <img width="25%" src="https://www.wisible.io/wp-content/uploads/2019/08/avatar-human-male-profile-user-icon-518358.png" alt="">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">แก้ไขรหัสผ่าน</h3>
                </div>
                <div class="card-body">
                    <form action="/aboutme/updatePassword/{{auth()->user()->id}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">รหัสผ่านเดิม</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="name" name="old_password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">รหัสผ่านใหม่</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="name" name="new_password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">ยืนยันรหัสผ่านใหม่</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="name" name="confirm_password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-block btn-outline-success btn-sm">บันทึก</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('header')
@endsection

@section('footer')
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
@endsection