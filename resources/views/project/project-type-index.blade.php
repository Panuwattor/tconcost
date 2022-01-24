@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">ประเภท โครงการ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">ประเภท โครงการ</li>
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
                    <h3 class="card-title">รายการประเภท โครงการ</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-block btn-outline-success btn-sm" data-toggle="modal" data-target="#modal-add">เพิ่มประเภท โครงการ</button>
                    </div>
                    <div class="modal fade" id="modal-add">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">เพิ่มประเภท โครงการ</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/project-type" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                    <span for="inputEmail3">ชื่อ</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ">
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
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ชื่อ</th>
                                    <th>note</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project_types as $project_type)
                                <tr>
                                    <td>{{$project_type->name}}</td>
                                    <td>{{$project_type->note}}</td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-outline-warning btn-sm w-auto" data-toggle="modal" data-target="#modal-update{{$project_type->id}}">แก้ไข</button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-update{{$project_type->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">เพิ่มประเภท โครงการ</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/project-type/update/{{$project_type->id}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 col-md-12">
                                                            <div class="form-group">
                                                                <span for="inputEmail3">ชื่อ</span>
                                                                <div>
                                                                    <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ" value="{{$project_type->name}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <span for="inputEmail3">note</span>
                                                                <div>
                                                                    <textarea class="form-control" rows="3" name="note" placeholder="Enter ...">{{$project_type->note}}</textarea>
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

@endsection

@section('footer')
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
@endsection