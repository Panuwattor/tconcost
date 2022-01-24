@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Purchase Order</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Purchase Order</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@include('po.head_po')
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-header">
                   <div class="card-tools">
                        <button type="button" class="btn btn-outline-success btn-sm w-auto" data-toggle="modal" data-target="#allocate_detail">รายละเอียดการจัดสรร</button>
                    </div>
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
                                <th>ส่วนลด พิเศษ</th>
                                <th>จำนวนเงิน</th>
                                @if($po->status == 1)
                                <th>จัดสรรต้นทุน</th>
                                @endif
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
                                <td>{{number_format($list->special_discount, 2)}}</td>
                                <td>{{number_format($list->price, 2)}}</td>
                                @if($po->status == 1)
                                <td>
                                    @if(!$list->allocate)
                                    <a href="/po/allocate/{{$list->id}}"><button type="button" class="btn btn-outline-info btn-sm w-auto">จัดสรรต้นทุน</button></a>
                                    @else
                                    @if($po->status != 2)
                                    <a href="/po/allocate/edit/{{$list->id}}"><button type="button" class="btn btn-outline-warning btn-sm w-auto">แก้ไข</button></a>
                                    @endif
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="allocate_detail">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">รายการจัดสรรต้นทุน</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-hover">
                                        <tbody>
                                            @foreach($po->purchaseOrderLists as $i => $list)
                                            <tr>
                                                @if($po->status == 1)

                                                @if($list->allocate)
                                                @foreach($list->allocate->allocate_list as $list)
                                                <td>
                                                    {{$list->project->name}}
                                                </td>
                                                <td>
                                                    {{$list->project_cost_plan_list->cost_plan->name}} / {{$list->project_cost_plan_list->costPlanLists->name}}
                                                </td>
                                                <td>
                                                    ใช้ {{number_format($list->price, 2)}} บาท
                                                </td>
                                                <td>
                                                    เหลือ {{number_format($list->project_cost_plan_list->cost - $list->project_cost_plan_list->use_cost, 2)}} บาท
                                                </td>
                                                @endforeach
                                                @endif

                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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

                <br>
                @if($po->po_type != 'NR' && $po->status == 1)
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-6">
                            <div class="description-block border-right border-left" data-toggle="modal" data-target="#modal-default">
                                <span class="description-percentage text-danger"><i class="fas fa-close"></i> Reject PO</span>
                                <br>
                                <button type="button" class="btn btn-outline-danger">ไม่อนุมัติ</button>
                            </div>

                            <div class="modal fade" id="modal-default">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">รายละเอียด</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <textarea name="reject_note" id="reject_note" cols="30" rows="3" class="form-control"></textarea>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="reject('{{$po->id}}')">ไม่อนุมัติ</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-info"><i class="fas fa-check-circle"></i> Approve PO Step 1</span>
                                <br>
                                @if($po->approve_user)
                                <span>{{$po->approve_user->name}}</span>
                                <br><span>เวลา {{$po->approve_user_time}}</span>
                                @else
                                <button type="button" class="btn btn-outline-info" onclick="approve('{{$po->id}}')">ผู้อนุมัติขั้นที่ 1</button>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-success"><i class="fas fa-check-circle"></i> Approve PO Step 2</span>
                                <br>
                                @if($po->main_approve_user)
                                <span>{{$po->main_approve_user->name}}</span>
                                <br><span>เวลา {{$po->main_approve_user_time}}</span>
                                @else
                                <button type="button" class="btn btn-outline-success" onclick="mian_approve('{{$po->id}}')" <?php if(!$po->approve_user){ print('disabled'); } ?>>ผู้อนุมัติขั้นที่ 2</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($po->status == 2)
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-6">
                        </div>

                        <div class="col-12 col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-info"><i class="fas fa-check-circle"></i> Approve PO Step 1</span>
                                <br>
                                @if($po->approve_user)
                                <span>{{$po->approve_user->name}}</span>
                                <br><span>เวลา {{$po->approve_user_time}}</span>
                                @else
                                <button type="button" class="btn btn-outline-info" onclick="approve('{{$po->id}}')">ผู้อนุมัติขั้นที่ 1</button>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-success"><i class="fas fa-check-circle"></i> Approve PO Step 2</span>
                                <br>
                                @if($po->main_approve_user)
                                <span>{{$po->main_approve_user->name}}</span>
                                <br><span>เวลา {{$po->main_approve_user_time}}</span>
                                @else
                                <button type="button" class="btn btn-outline-success" onclick="mian_approve('{{$po->id}}')" <?php if(!$po->approve_user){ print('disabled'); } ?>>ผู้อนุมัติขั้นที่ 2</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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
<script>
    function approve(id) {
        if (confirm('ต้องการอนุมัติ ?')) {
            location.href = '/po/approve/' + id;

            history.replaceState({
                urlPath: '/po/show/approve/' + id
            }, "", '/')
        }

    }

    function mian_approve(id) {
        if (confirm('ต้องการอนุมัติ ?')) {
            location.href = '/po/main-approve/' + id;

            history.replaceState({
                urlPath: '/po/show/approve/' + id
            }, "", '/')
        }
    }

    function sentApprove(id) {
        if (confirm('ยืนยัน ขออนุมัติ PO ?')) {
            location.href = "/po/sent/" + id;

            history.replaceState({
                urlPath: '/po/show/approve/' + id
            }, "", '/')
        }
    }

    function cancle(id) {
        if (confirm('ยืนยัน ยกเลิก PO ?')) {
            location.href = "/po/cancle/" + id;

            history.replaceState({
                urlPath: '/po/show/approve/' + id
            }, "", '/')
        }
    }

    function reject(id) {
        var reject_note = document.getElementById('reject_note').value;
        if (!reject_note) {
            alert('กรอกข้อมูลให้ครบถ้วน');
            return;
        }
        if (confirm('ไม่อนุมัติ ?')) {
            location.href = '/po/reject/' + id + '/' + reject_note;

            history.replaceState({
                urlPath: '/po/show/approve/' + id
            }, "", '/')
        }
    }
</script>
@endsection