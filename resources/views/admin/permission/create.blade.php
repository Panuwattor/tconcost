@extends('master')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Permission Create</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item"><a href="/jb/admin/permissions">permissions</a></li>
          <li class="breadcrumb-item active">create</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="row justify-content-center">
      <div class="col-12">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                  <div class="card">
                      <div class="card-header">
                          <h3 class="card-title"> Add a new Permission</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      <form method="post" class="form-horizontal" action="/jb/admin/permission" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <div class="card-body">
                            <div class="form-group col-md-12">
                              <h4>Name</h4>
                              <input type="text" name="name" value="" class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group col-md-12">
                              <h4>Note</h4>
                              <input type="text" name="note" class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group col-md-12">
                              <h4>Roles</h4>
                              <div class="row">
                                @foreach($roles as $role)
                                <div class="form-group col-md-4">
                                  <div class="checkbox">
                                    <label>
                                      <input type="checkbox" name="roles[]" value="{{$role->id}}"> {{$role->name}}  <small>({{$role->note}})</small>
                                    </label>
                                  </div>
                                </div>
                                @endforeach
                              </div>
                            </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <button type="submit" class="btn btn-success float-right">บันทึก</button>
                          </div>
                          <!-- /.card-footer -->
                      </form>
                  </div>
              </div>
      </div>
  </div>
</section>

@endsection
