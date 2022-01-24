@extends('master')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Permissions</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">permissions</li>
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-cogs"></i> Permissions</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <div class="input-group-append">
                            <a href="/jb/admin/permission/create"><button type="button" class="btn btn-primary btn-sm">addPermission</button></a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Note</th>
                            <th>Roles</th>
                            <th>action</th>
                        </tr>
                      </thead>
                    </tbody>
                      @foreach ($permissions as $permission)
                        <tr  class="text-center">
                          <td>{{ $permission->name }}</td>
                          <td>{{ $permission->note }}</td>
                          <td>
                            @foreach($permission->roles as $role)
                              <span class="badge bg-success">{{ $role->name }}</span>
                            @endforeach
                          </td>
                          <td>
                          	<a href="/jb/admin/permission/{{$permission->id}}/edit" class="btn btn-sm btn-default"><i class="fa fa-edit"></i> Edit</a>
                    	  	</td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
