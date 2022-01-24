@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Purchase Order</h1>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-11 text-right">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Purchase Order</li>
                        </ol>
                    </div>
                    
                    @include('po.po_nav')
                </div>
            </div>
        </div>
    </div>
</div>

@include('po.head_po')
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">รายการสั่งซื้อ</h3>
            </div>
            <div class="card-body">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr class="text-center">
                                <th>ลำดับ</th>
                                <th>Category</th>
                                <th>รายการ</th>
                                <th>จำนวน</th>
                                <th>หน่วย</th>
                                <th>ราคาต่อหน่วย</th>
                                <th>ส่วนลด/หน่วย</th>
                                <th>จำนวนเงิน</th>
                                <th>จัดสรรต้นทุน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($po->purchaseOrderLists as $i => $list)
                            <tr class="text-center">
                                <td>{{$i + 1}}</td>
                                <td>
                                @if($list->allocate)
                                @foreach($list->allocate->allocate_list as $no => $allocate_list)
                                    {{$allocate_list->project_cost_plan_list->costPlanLists->code}}: {{$allocate_list->project_cost_plan_list->costPlanLists->name}}
                                    @if($no < $list->allocate->allocate_list->count() - 1)
                                    ,
                                    @endif
                                @endforeach
                                @else
                                    ยังไม่จัดสรรต้นทุน
                                @endif
                                </td>
                                <td>{{$list->name}}</td>
                                <td>{{$list->amount}}</td>
                                <td>{{$list->unit}}</td>
                                <td>{{number_format($list->unit_price, 3)}}</td>
                                <td>{{number_format($list->unit_discount, 2)}}</td>
                                <td>{{number_format($list->price, 2)}}</td>
                                <td>
                                    @if(!$list->allocate)
                                    <a href="/po/allocate/{{$list->id}}"><button type="button" class="btn btn-outline-info btn-sm w-auto">จัดสรรต้นทุน</button></a>
                                    @else
                                    <button type="button" class="btn btn-outline-success btn-sm w-auto" data-toggle="modal" data-target="#allocate_detail{{$list->id}}">รายละเอียด</button>
                                    @if(auth()->user()->id == $po->user->id && auth()->user()->hasRole(['developer']) && $po->status != 2)
                                    <a href="/po/allocate/edit/{{$list->id}}"><button type="button" class="btn btn-outline-warning btn-sm w-auto">แก้ไข</button></a>
                                    @endif
                                    @endif
                                </td>
                            </tr>

                                @foreach($list->listNotes as $_note)
                                <tr class="text-center" style="background-color: #ddd;">
                                    <td></td>
                                    <td colspan="7">{{$_note->note}}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            @if($list->allocate)
                            <div class="modal fade" id="allocate_detail{{$list->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">รายการจัดสรรต้นทุน</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach($list->allocate->allocate_list as $list)
                                            <div class="row">
                                                <div class="col-3">
                                                    {{$list->project->name}}
                                                </div>
                                                <div class="col-4">
                                                    {{$list->project_cost_plan_list->cost_plan->name}} / {{$list->project_cost_plan_list->costPlanLists->name}}
                                                </div>
                                                <div class="col-2">
                                                    ใช้ {{number_format($list->price, 2)}} บาท
                                                </div>
                                                <div class="col-3">
                                                    เหลือ {{number_format($list->project_cost_plan_list->cost - $list->project_cost_plan_list->use_cost, 2)}} บาท
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-default" style="float: right;" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <br>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <span>ไฟล์ :
                                @foreach($po->poFiles as $no => $pofile)
                                <a target="bank" href="{{ Storage::disk('spaces')->url($pofile->file) }}"><span style="text-decoration: underline #007bff;"> ไฟล์ {{$no + 1}} </span></a>
                                @endforeach
                            </span>
                        </div>
                        <div class="form-group">
                            <span>PR :
                                @foreach($po->poHasprs as $i => $poHaspr)
                                <a target="bank" href="/pr/show/{{$poHaspr->pr_id}}"><span style="text-decoration: underline #007bff;">({{$i + 1}}) {{$poHaspr->pr->pr_id}} </span></a>
                                @endforeach
                            </span>
                        </div>
                        <div class="form-group">
                            <span>ชำระเงิน : <span style="text-decoration: underline gray;">{{$po->payment_type}} @if($po->payment_type == 'เครดิต') {{$po->cradit}} วัน @endif</span></span>
                        </div>
                        <div class="form-group">
                            <span>เงื่อนไขการชำระ : <span style="text-decoration: underline gray;">{{$po->patment_condition}}</span></span>
                        </div>
                        <div class="form-group">
                            <span>หมายเหตุ : <span style="text-decoration: underline gray;">{{$po->note}}</span></span>
                        </div>
                        <div class="form-group">
                            <span>ผู้สร้าง : <span style="text-decoration: underline gray;">{{$po->user->name}}</span></span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-right">
                        @if($po->vat_type == 'นอก' || $po->vat_type == 'ใน')
                        <div class="form-group">
                            <span>จำนวนเงิน : <span style="text-decoration: underline gray;">{{number_format($po->sum_price, 2)}}</span></span>
                        </div>
                        <div class="form-group">
                            <span>
                                VAT :
                                <span style="text-decoration: underline gray;">
                                    @if($po->vat_type)
                                    {{number_format($po->vat_amount, 2)}}
                                    @endif
                                </span>
                            </span>
                        </div>
                        @endif
                        <div class="form-group">
                            <span>จำนวนเงินรวมทั้งสิ้น : <span style="text-decoration: underline gray;">{{number_format($po->vat_amount + $po->sum_price, 2)}}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
@endsection

@section('header')
<style>
    body {
        font-family: "Lato", sans-serif;
    }

    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 100000000;
        top: 0;
        right: 0;
        background-color: #212529;
        overflow-x: hidden;
        transition: 0.5s;
        color: #c2c7d0;
    }

    .sidenav a {
        /* padding: 8px 8px 8px 32px; */
        text-decoration: none;
        /* font-size: 25px; */
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }
</style>
@endsection

@section('footer')
<script>
    function sentApprove(id) {
        if (confirm('ยืนยัน ขออนุมัติ PO ?')) {
            location.href = "/po/sent/" + id;
        }
    }

    function cancle(id) {
        if (confirm('ยืนยัน ยกเลิก PO ?')) {
            location.href = "/po/cancle/" + id;
        }
    }

    function delete_recive() {
        if (confirm('ต้องการลบรายการรับของ ใช่หรือไม่ ?')) {
            var form = document.getElementById('delete_recive');
            form.submit();
        }
    }
    
    function delete_deposit() {
        if (confirm('ต้องการลบรายการตั้งหนี้ ใช่หรือไม่ ?')) {
            var form = document.getElementById('delete_deposit');
            form.submit();
        }
    }
</script>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>
@endsection