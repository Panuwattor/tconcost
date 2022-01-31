@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">โครงการ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">โครงการ</li>
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
                    <h3 class="card-title">รายการโครงการ</h3>
                    <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                         <a href="/project/create" type="button" class="btn btn-block btn-outline-success"><i class="fas fa-plus"></i> Create Project</a>
                    </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table id="example1" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>ชื่อโครงการ</th>
                                    <th class="text-right">มูลค่าสัญญา</th>
                                    <th>วันที่เริ่มต้น</th>
                                    <th>วันที่สิ้นสุด</th>
                                    <th>ผู้รับผิดชอบโครงการ</th>
                                    <th>สถานะ</th>
                                    <th class="text-center">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $i => $project)
                                <tr>
                                    <td>#{{$project->id}}</td>
                                    <td>{{$project->customer ? $project->customer->name : ''}}</td>
                                    <td><a href="/project/show/{{$project->id}}">{{$project->code}} {{$project->name}}</a></td>
                                    <td class="text-right">{{number_format($project->project_cost, 2)}}</td>
                                    <td>{{$project->start_date}}</td>
                                    <td>{{$project->finish_date}}</td>
                                    <td>{{$project->main_user->name}}</td>
                                    <td>{!! $project->state !!}</td>
                                    <td>
                                        <a href="/project/show/{{$project->id}}"><button type="button" class="btn btn-block btn-outline-info btn-sm">รายละเอียด</button></a>
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
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $(function () {
    $('#example1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endsection