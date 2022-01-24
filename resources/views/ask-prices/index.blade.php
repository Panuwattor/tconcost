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
                    <li class="breadcrumb-item active">ขอราคา</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">ขอราคา</h3>

        <div class="card-tools">
            <a href="/ask-price/create"><button type="button" class="btn btn-block btn-outline-info btn-sm">ขอราคา</button></a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>ลำดับ</th>
                    <th>Order</th>
                    <th>AP ID</th>
                    <th>ผู้ดูแล</th>
                    <th>วันที่ขอ</th>
                    <th>วันที่หมดอายุ</th>
                    <th>note</th>
                    <th>ผู้สร้าง</th>
                    <th>รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ask_prices as $i => $ask_price)
                <tr class="text-center">
                    <td>{{$i + 1}}</td>
                    <td>{{$ask_price->project->name}}</td>
                    <td>#{{$ask_price->ap_id}}</td>
                    <td>{{$ask_price->main_user->name}}</td>
                    <td>{{$ask_price->ap_date}}</td>
                    <td>{{$ask_price->finish_date}}</td>
                    <td>{{$ask_price->note}}</td>
                    <td>{{$ask_price->user->name}}</td>
                    <td>
                        <a href="/ap/show/{{$ask_price->id}}"><button type="button" class="btn btn-block btn-outline-info btn-sm">รายละเอียด</button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection

@section('header')
@endsection

@section('footer')
@endsection