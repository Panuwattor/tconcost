@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Customer / Supplier</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/customers">รายการลูกค้า</a></li>
                    <li class="breadcrumb-item active">show</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">

    <!-- Default box -->
    <div class="card" @if($customer->status == 'cancel') style="background-color: #FED1D1;" @endif>
        <div class="card-header">
            <h3 class="card-title">รายละเอียด Detail   @if($customer->status == 'cancel') <span class="badge bg-danger">รายการ Cancel</span> @endif</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="post">
                                <h4>ข้อมูลเบื้องต้น</h4>
                                <span class="username">
                                    <h6 class="text-primary"> <i class="fa fa-dot-circle-o"></i> ชื่อ : {{$customer->name}}</h6>
                                </span>
                                <!-- /.user-block -->
                                <h6> <i class="fa fa-dot-circle-o"></i> ประเภท : {{$customer->status}}</h6>
                                <h6> <i class="fa fa-dot-circle-o"></i> โทรศัพท์ : {{$customer->tel}}</h6>
                                <h6> <i class="fa fa-dot-circle-o"></i> โทรสาร : {{$customer->fax}}</h6>
                                <h6> <i class="fa fa-dot-circle-o"></i> ที่อยู่ : {{$customer->address}}</h6>
                                <h6> <i class="fa fa-dot-circle-o"></i> อีเมลล์ : {{$customer->email}}</h6>
                                <h6> <i class="fa fa-dot-circle-o"></i> เลขประจำตัว : {{$customer->txt_tin}}</h6>
                                <h6> <i class="fa fa-dot-circle-o"></i> Note : {{$customer->note}}</h6>
                                <div class="text-right">
                                    <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#modal-edit{{$customer->id}}"> <i class="fa fa-edit"></i> แก้ไข</button>
                                </div>
                                <div class="modal fade" id="modal-edit{{$customer->id}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><i class="fa fa-edit"></i> แก้ไข ข้อมูลเบื้องต้น</h4>
                                            </div>
                                            <form action="/customer/update/{{$customer->id}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <span for="inputEmail3">ชื่อ</span>
                                                                <div>
                                                                    <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ" value="{{$customer->name}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <span for="inputEmail3">โทร</span>
                                                                <div>
                                                                    <input required type="text" class="form-control" id="inputEmail3" name="tel" placeholder="โทรศัพท์" value="{{$customer->tel}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <span for="inputEmail3">โทรสาร</span>
                                                                <div>
                                                                    <input type="text" class="form-control" id="inputEmail3" name="fax" placeholder="โทรสาร" value="{{$customer->fax}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <span for="inputEmail3">อีเมลล์</span>
                                                                <div>
                                                                    <input type="text" class="form-control" id="inputEmail3" name="email" placeholder="อีเมลล์" value="{{$customer->email}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <span for="inputEmail3">เลขประจำตัวผู้เสียภาษี</span>
                                                                <div>
                                                                    <input type="text" class="form-control" id="inputEmail3" name="txt_tin" placeholder="เลขประจำตัวผู้เสียภาษี" value="{{$customer->txt_tin}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <span for="inputEmail3">สถานะ</span>
                                                                <div>
                                                                    <select class="form-control" name="status" id="status">
                                                                        <option value="customer" @if($customer->status == 'customer') selected @endif>ลูกค้า</option>
                                                                        <option value="supplier" @if($customer->status == 'supplier') selected @endif>ผู้ขาย</option>
                                                                        <option value="customer , supplier" @if($customer->status == 'customer , supplier') selected @endif>ลูกค้า , ผู้ขาย</option>
                                                                        <option value="cancel" @if($customer->status == 'cancel') selected @endif>ยกเลิก</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <span for="inputEmail3">ที่อยู่</span>
                                                                <div>
                                                                    <textarea required class="form-control" rows="3" name="address" placeholder="Enter ...">{{$customer->address}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <span for="inputEmail3">note</span>
                                                                <div>
                                                                    <textarea class="form-control" rows="3" name="note" placeholder="Enter ...">{{$customer->note}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                                                    <button type="submit" class="btn btn-warning">ยืนยัน</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="col-12 col-md-12 col-lg-6 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12">

                            <div class="post clearfix">
                                <h4>Contact Person</h4>
                                <div class="row">
                                    @foreach($customer->contracts as $contract)
                                    <div class="col-12 col-sm-6">

                                        <div class="info-box bg-light">
                                            @if($contract->status == 1)
                                            <div class="ribbon-wrapper">
                                                <div class="ribbon bg-success">
                                                    ใช้งาน
                                                </div>
                                            </div>
                                            @else
                                            <div class="ribbon-wrapper">
                                                <div class="ribbon bg-warning">
                                                    ยกเลิก
                                                </div>
                                            </div>
                                            @endif
                                            <div class="info-box-content">
                                                <span class="info-box-number text-left text-muted">Name : {{$contract->name}}</span>
                                                <span class="info-box-text text-left text-muted mb-0">Tal : {{$contract->tel}}</span>
                                                <button class="btn btn-outline-warning btn-xs pull-left" data-toggle="modal" data-target="#modal-editPerson{{$contract->id}}"><i class="fa fa-edit"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modal-editPerson{{$contract->id}}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Contact Person</h4>
                                                </div>
                                                <form action="/edit/contract/{{$contract->id}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <span>ชื่อ</span>
                                                                    <div>
                                                                        <input required type="text" class="form-control" value="{{$contract->name}}" name="name" placeholder="ชื่อ">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <span>โทร</span>
                                                                    <div>
                                                                        <input required type="text" class="form-control" value="{{$contract->tel}}" name="tel" placeholder="โทรศัพท์">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label>สถานะ</label>
                                                                    <select class="form-control" name="status">
                                                                        <option value="1" @if($contract->status == 1) selected @endif>ใช้งาน</option>
                                                                        <option value="0" @if($contract->status == 0) selected @endif>ยกเลิก</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-warning">ยืนยัน</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#modal-addPerson"> <i class="fa fa-user"></i> Add Person</button>
                                </div>
                                <div class="modal fade" id="modal-addPerson">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Add Contact Person</h4>
                                            </div>
                                            <form action="/add/contract/{{$customer->id}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <span for="inputEmail3">ชื่อ</span>
                                                                <div>
                                                                    <input required type="text" class="form-control" id="inputEmail3" name="name" placeholder="ชื่อ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <span for="inputEmail3">โทร</span>
                                                                <div>
                                                                    <input required type="text" class="form-control" id="inputEmail3" name="tel" placeholder="โทรศัพท์">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                                                    <button type="submit" class="btn btn-success">ยืนยัน</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection