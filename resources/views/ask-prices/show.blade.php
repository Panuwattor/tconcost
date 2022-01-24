@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">ขอราคา</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="/ask-price">รายการขอราคา</a></li>
                    <li class="breadcrumb-item active">ขอราคา</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ใบขอราคา</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <span>PR ID : <span style="text-decoration: underline gray;">{{$ap->ap_id}}</span></span>
                </div>
                <div class="form-group">
                    <span>Order : <span style="text-decoration: underline gray;">{{$ap->project->name}}</span></span>
                </div>
                <div class="form-group">
                    <span>ผู้ดูแล : <span style="text-decoration: underline gray;">{{$ap->user->name}}</span></span>
                </div>
                <div class="form-group">
                    <span>เบอร์โทร : <span style="text-decoration: underline gray;">{{$ap->tel}}</span></span>
                </div>
                <div class="form-group">
                    <span>วันที่ขอ : <span style="text-decoration: underline gray;">{{$ap->ap_date}}</span></span>
                </div>
                <div class="form-group">
                    <span>วันที่รับ : <span style="text-decoration: underline gray;">{{$ap->finish_date}}</span></span>
                </div>
                <div class="form-group">
                    <span>ที่อยู่ : <span style="text-decoration: underline gray;">{{$ap->address}}</span></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ใบขอราคา</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <span>รายละเอียดการจัดส่ง : <span style="text-decoration: underline gray;">{{$ap->delivery}}</span></span>
                </div>
                <div class="form-group">
                    <span>ไฟล์ :
                        @if($ap->photo)
                        <a target="bank" href="/storage/{{ $ap->photo }}"><span style="text-decoration: underline #007bff;"> {{ $ap->photo }}</span></a>
                        @else
                        <span class="text-primary">ไม่มีไฟล์</span>
                        @endif
                    </span>
                </div>
                <div class="form-group">
                    <span>note : <span style="text-decoration: underline gray;">{{$ap->note}}</span></span>
                </div>
                <div class="form-group">
                    <span>Supplier :
                        @foreach($ap->askPriceSuppliers as $i => $supplier)
                        <a target="bank" href="/ap/print/{{$ap->id}}/{{$supplier->customer->id}}"><span style="text-decoration: underline #007bff; color: #007bff;">
                            <i class="fa fa-print"></i>
                            {{$supplier->customer->name}}
                            @if($i != $ap->askPriceSuppliers->count() - 1), &nbsp;@endif
                        </span></a>
                        @endforeach
                    </span>
                </div>
                <div class="form-group">
                    <span>ผู้สร้าง : <span style="text-decoration: underline gray;">{{$ap->user->name}}</span></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">รายการขอราคา</h3>
            </div>
            <div class="card-body">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รายการขอราคา</th>
                                <th>จำนวน</th>
                                <th>หน่วย</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ap->Ask_price_lits as $i => $list)
                            <tr>
                                <td>{{$i + 1}}</td>
                                <td>{{$list->name}}</td>
                                <td>{{$list->amount}}</td>
                                <td>{{$list->unit}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
@endsection

@section('header')
@endsection

@section('footer')
@endsection