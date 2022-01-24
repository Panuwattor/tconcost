@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">รายการรับของ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">รายการรับของ</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">รายการรับของ</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <div class="row">
            <div class=""></div>
        </div>
        <table class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>โครงการ</th>
                    <th>Receive ID</th>
                    <th>PO ID</th>
                    <th>จำนวนเงิน</th>
                    <th>VAT</th>
                    <th>รวม</th>
                    <th>ประเภท</th>
                    <th>ยังคงเหลือ</th>
                    <th>เปอร์เซ็นต์</th>
                    <th>ผู้ขาย</th>
                    <th>เงื่อนไขการชำระ</th>
                    <th>note</th>
                    <th>ผู้รับ</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td>{{$receive->project->name}}</td>
                    <td>{{$receive->receive_code}}</td>
                    <td><a target="_bank" href="/receive/po/show/{{$receive->po->id}}">{{$receive->po->po_id}}</a></td>
                    <td>{{number_format($receive->sum_price,2)}}</td>
                    <td>{{number_format($receive->vat_amount,2)}}</td>
                    <td>{{number_format($receive->sum,2)}}</td>
                    <td>{{$receive->type}}</td>
                    <td>{{number_format($receive->po_remain,2)}}</td>
                    <td>{{$receive->po_remain_percent}}%</td>
                    <td>{{$receive->supplier->name}}</td>
                    <td>{{$receive->payment_condition}}</td>
                    <td>{{$receive->note}}</td>
                    <td>{{$receive->user->name}}</td>
                </tr>
            </tbody>
        </table>
        @if($receive->receive_files->count() > 0)
        <div class="card-header">
            <div class="form-group">
                <label>แนบ File</label>
                @foreach($receive->receive_files as $i => $file)
                <a target="_bank" href="{{ Storage::disk('spaces')->url($file->file) }}"><span class="right badge badge-info">ไฟล์ {{$i + 1}}</span></a>
                @endforeach
            </div>
        </div>
        @endif
        @if($receive->retention)
        <div class="card-header">
            <div class="form-group">
                <label>เงินประกันผลงาน</label>
                <span>{{number_format($receive->retention->price, 2)}}</span>
            </div>
        </div>
        @endif
        @if($receive->duedate)
        <div class="card-header">
            <div class="form-group">
                <b>วันที่เริ่ม : </b> <span>{{$receive->duedate->start}}</span>
                <b>วันที่สิ้นสุด : </b> <span>{{$receive->duedate->finish}}</span>
            </div>
        </div>
        @endif

        <div class="card-header">
            <h3 class="card-title">รายละเอียด</h3>
        </div>
        <table class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>ลำดับ</th>
                    <th>รายการ</th>
                    <th>จำนวน</th>
                    <th>หน่วย</th>
                    <th>ราคาต่อหน่วย</th>
                    <th>ส่วนลด/หน่วย</th>
                    <th>จำนวนเงิน</th>
                </tr>
            </thead>
            <tbody>
                @foreach($receive->receive_lists as $index => $list)
                <tr class="text-center">
                    <td>{{$index + 1}}</td>
                    <td>{{$list->name}}</td>
                    <td>{{$list->amount}}</td>
                    <td>{{$list->unit}}</td>
                    <td>{{number_format($list->unit_price, 3)}}</td>
                    <td>{{number_format($list->unit_discount, 2)}}</td>
                    <td>{{number_format($list->price, 2)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('header')
@endsection

@section('footer')
@endsection