@extends('master')

@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-success card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                 @if(auth()->user()->photo)
                  <img src="{{ Storage::disk('spaces')->url(auth()->user()->photo) }}" alt="User profile picture" class="profile-user-img img-fluid img-circle">
                  @else
                  <img src="https://www.wisible.io/wp-content/uploads/2019/08/avatar-human-male-profile-user-icon-518358.png" alt="User Avatar" class="profile-user-img img-fluid img-circle">
                  @endif
                </div>

                <h3 class="profile-username text-center">{{$user->name}}</h3>

                <p class="text-center text-success">{{$user->email}}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>แต้ม</b> <a class="float-right  text-success">{{$user->point}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>สาขา</b> <a class="float-right">@if($user->branch) {{$user->branch->name}} @else ยังไม่เลือกสาขา @endif</a>
                  </li>
                </ul>

                <button data-toggle="modal" data-target="#editUserModal{{$user->id}}" class="btn btn-block"> <i class="fa fa-edit"></i> แก้ไขข้อมูล</button>
              </div>
              <div class="modal fade" id="editUserModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-edit"></i> แก้ไข User</h5>
                    </div>
                      <form method="post" class="form-horizontal" action="/admin/auth/user/update/{{$user->id}}" enctype="multipart/form-data">
                          {{ csrf_field() }}
                        <div class="modal-body">
                          <div class="form-group">
                            <label>รุป</label>
                            <input class="form-control" type="file" name="photo" multiple>
                          </div>
                          <div class="form-group">
                              <label for="inputPassword3" class="col-control-label">ชื่อ</label>
                              <div class="col-sm-12">
                                  <input type="text" placeholder="ชื่อ" class="form-control" value="{{$user->name}}" name="name" required>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="inputPassword3" class="col-control-label">Password</label>
                              <div class="col-sm-12">
                                  <input type="text" placeholder="ถ้าไม่เปลี่ยนไม่ต้องกรอก Password" class="form-control" name="password" minlength="4" maxlength="20">
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
            </div>
            <!-- /.card -->
            @if($matchget)
              @if($user->exchangePoint == 1)
              <div class="row">
                  <!-- /.col -->
                  <div class="col-md-12">
                    <a href="#"  data-toggle="modal" data-target="#matchToMytcg{{$user->id}}">
                      <div class="card">
                        <div class="description-block">
                          <h5 class="description-text ">โอนแต้มไปยัง Mytcg</h5>
                          <span class="text-success"> {{$user->point}}</span>
                          <span class="description-percentage mr-3 ml-3"><i class="fa fa-random"></i></span>
                          <span class="description-header text-muted">{{$matchget->point}}</span>
                          <h4 class="text-center"><i class="fa fa-hand-o-up"></i></h4>
                        </div>
                        <!-- /.description-block -->
                      </div>
                    </a>
                  </div>
                </div>
                <div class="modal fade" id="matchToMytcg{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title text-success"> <i class="fa fa-random"></i> โอนแต้มไปที่ Mytcg</h5>
                    </div>
                      <form method="post" class="form-horizontal" action="/match/to/mytcg/{{$user->id}}" enctype="multipart/form-data">
                          {{ csrf_field() }}
                        <div class="modal-body">
                          <div class="form-group">
                            <label>โอนแต้มจำนวน</label>
                            <input type="number" step="any" placeholder="จำนวนแต้มที่โอน" max="{{$user->point}}" class="form-control text-center" value="{{$user->point}}" name="point" required>
                            <input type="hidden" placeholder="code" class="form-control text-center" value="{{$user->id . Carbon\Carbon::now()}}" name="code" required>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">ยืนยันการโอน</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              @endif
            <!-- Profile Image -->
            <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-share-alt-square"></i> จับคู่ Mytcg</h3>
              </div>
              <div class="card-body box-profile">
                <div class="text-center">
                  @if($matchget->photo)
                    <img class="profile-user-img img-fluid img-circle" src="https://mytcg.net/storage/{{$matchget->photo}}" alt="User profile picture">
                  @else
                    <img class="profile-user-img img-fluid img-circle" src="/img/user.png" alt="User profile picture">
                  @endif
                </div>

                <h3 class="profile-username text-center">{{$matchget->name}}</h3>

                <p class="text-center text-success">{{$matchget->email}}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>แต้ม</b> <a class="float-right">{{$matchget->point}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>ตำแหน่ง</b> <a class="float-right">{{$matchget->position}}</a>
                  </li>
                </ul>
                <button data-toggle="modal" data-target="#matchUserEdit{{$user->id}}" class="btn "> <i class="fa fa-edit"></i> แก้ไขการจับคู่</button>
              </div>
              <div class="modal fade" id="matchUserEdit{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-share-alt-square"></i> จับคู่ Mytcg</h5>
                    </div>
                      <form method="post" class="form-horizontal" action="/admin/match/user/edit/{{$user->id}}" enctype="multipart/form-data">
                          {{ csrf_field() }}
                        <div class="modal-body">
                          <div class="form-group">
                            <label>เลือก ชื่อ</label>
                            <select class="form-control" name="match_id">
                              @foreach($objs as $getuser)
                              <option value="{{$getuser->id}}">{{$getuser->nickName}} : {{$getuser->firstName}} {{$getuser->lastName}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">ยืนยันแก้ไขจับคู่</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            </div>
            <!-- /.card -->
            @else
            <div class="card card-outline">
              <div class="card-body box-profile">
               <button data-toggle="modal" data-target="#matchUser{{$user->id}}" class="btn btn-block btn-outline-success btn-lg"> <i class="fa fa-share-alt-square"></i> จับคู่ Mytcg</button>
              </div>
              <div class="modal fade" id="matchUser{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-share-alt-square"></i> จับคู่ Mytcg</h5>
                    </div>
                      <form method="post" class="form-horizontal" action="/admin/match/user/{{$user->id}}" enctype="multipart/form-data">
                          {{ csrf_field() }}
                        <div class="modal-body">
                          <div class="form-group">
                            <label>เลือก ชื่อ</label>
                            <select class="form-control" name="match_id">
                              @foreach($objs as $getuser)
                              <option value="{{$getuser->id}}">{{$getuser->nickName}} : {{$getuser->firstName}} {{$getuser->lastName}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">ยืนยันจับคู่</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            </div>
            @endif
          </div>
          <!-- /.col -->
          <div class="col-md-9">

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
@endsection

