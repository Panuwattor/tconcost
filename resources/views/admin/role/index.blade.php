@extends('master')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"> Roles</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">roles</li>
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
                <h3 class="card-title"> <i class="fa fa-cogs"></i> Roles</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <div class="input-group-append">
                            <a href="/jb/admin/role/create"><button type="button" class="btn btn-primary btn-sm">addRole</button></a>
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
                            <th>Permissions</th>
                            <th>action</th>
                        </tr>
                      </thead>
                    </tbody>
                      @foreach ($roles as $role)
                        <tr  class="text-center">
                          <td>{{ $role->name }}</td>
                          <td>{{ $role->note }}</td>
                          <td>
                            @foreach($role->permissions as $permission)
                              <span class="badge bg-success">{{ $permission->name }}</span>
                            @endforeach
                          </td>
                          <td>
                          	<a href="/jb/admin/role/{{$role->id}}/edit" class="btn btn-sm btn-default"><i class="fa fa-edit"></i> Edit</a>
                    	  	</td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
