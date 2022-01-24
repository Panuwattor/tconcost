@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">ลูกค้า</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/customers">รายการลูกค้า</a></li>
                    <li class="breadcrumb-item active">ลูกค้า</li>
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
                    <h3 class="card-title">รายการลูกค้า</h3>
                </div>
                <div class="card-body">
                <form action="/customer" method="post">
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
                                                <div class="form-group">
                                                    <span for="inputEmail3">โทร</span>
                                                    <div>
                                                        <input required type="text" class="form-control" id="inputEmail3" name="tel" placeholder="โทรศัพท์">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">โทรสาร</span>
                                                    <div>
                                                        <input type="text" class="form-control" id="inputEmail3" name="fax" placeholder="โทรสาร">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">อีเมลล์</span>
                                                    <div>
                                                        <input type="text" class="form-control" id="inputEmail3" name="email" placeholder="อีเมลล์">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">เลขประจำตัวผู้เสียภาษี</span>
                                                    <div>
                                                        <input type="text" class="form-control" id="inputEmail3" name="txt_tin" placeholder="เลขประจำตัวผู้เสียภาษี">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <span for="inputEmail3">สถานะ</span>
                                                    <div>
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="customer">customer</option>
                                                            <option value="supplier">supplier</option>
                                                            <option value="customer , supplier">customer , supplier</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span for="inputEmail3">ที่อยู่</span>
                                                    <div>
                                                        <textarea required class="form-control" rows="3" name="address" placeholder="Enter ..."></textarea>
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
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection