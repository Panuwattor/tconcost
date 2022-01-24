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

<div class="row">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                 <div class="card-tools">
                  <a href="/po/print/{{$po->id}}" target="back_"><button type="button" class="btn btn-outline-secondary btn-xs"><i class="fa fa-print"></i> พิมพ์</button> </a>
                </div>
                <h3 class="card-title">ใบสั่งซื้อ </h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <span>PO ID : <span style="text-decoration: underline gray;">{{$po->code}}</span></span>
                </div>
                <div class="form-group">
                    <span>โครงการ : <span style="text-decoration: underline gray;">{{$po->project->name}}</span></span>
                </div>
                <div class="form-group">
                    <span>ผู้ขาย : <span style="text-decoration: underline gray;">{{$po->supplier->name}}</span></span>
                </div>
                <div class="form-group">
                    <span>ผู้ติดต่อ :
                        <span style="text-decoration: underline gray;">
                            @if($po->contract)
                            {{$po->contract->name}}
                            @else
                            -
                            @endif
                        </span>
                    </span>
                </div>
                <div class="form-group">
                    <span>วันที่ขอ : <span style="text-decoration: underline gray;">{{$po->po_date}}</span></span>
                </div>
                <div class="form-group">
                    <span>วันที่รับ : <span style="text-decoration: underline gray;">{{$po->due_date}}</span></span>
                </div>
                <div class="form-group">
                    <span>สถานะ : <span style="text-decoration: underline gray;">{!!$po->postatus!!}</span></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ข้อมูลที่อยู่จัดส่ง</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <span>ผู้ดูแล : <span style="text-decoration: underline gray;">{{$po->main_user->name}}</span></span>
                </div>
                <div class="form-group">
                    <span>เบอร์โทร : <span style="text-decoration: underline gray;">{{$po->tel}}</span></span>
                </div>
                <div class="form-group">
                    <span>ที่อยู่ : <span style="text-decoration: underline gray;">{{$po->address}}</span></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    @include('po.allocate_detail')
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
                                <th>VAT</th>
                                <!-- @if($po->status == 1)
                                <th>จัดสรรต้นทุน</th>
                                @endif -->
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
                                <td>
                                    {{$list->vat}}
                                </td>
                                <!-- @if($po->status == 1)
                                <td>
                                    @if(!$list->allocate)
                                    <a href="/po/allocate/{{$list->id}}"><button type="button" class="btn btn-outline-info btn-sm w-auto">จัดสรรต้นทุน</button></a>
                                    @else
                                    <button type="button" class="btn btn-outline-success btn-sm w-auto" data-toggle="modal" data-target="#allocate_detail{{$list->id}}">รายละเอียด</button>
                                    @if($po->status != 2)
                                    <a href="/po/allocate/edit/{{$list->id}}"><button type="button" class="btn btn-outline-warning btn-sm w-auto">แก้ไข</button></a>
                                    @endif
                                    @endif
                                </td>
                                @endif -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @foreach($po->purchaseOrderLists as $i => $list)
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
                <div class="row">
                    <div class="col-12">
                        @if($po->status == 0 && auth()->user()->id == $po->user->id)
                        <button type="button" class="btn btn-success btn-md w-auto float-right" onclick="sentApprove('{{$po->id}}')">ขออนุมัติ</button>
                       
                        <button type="button" class="btn btn-danger btn-md w-auto" onclick="cancle('{{$po->id}}')">ยกเลิก</button>
                        
                        <button type="button" class="btn btn-warning btn-md w-auto" onclick="edit('{{$po->id}}')">แก้ไข</button>
                        @endif
                    </div>
                </div>

                @if($po->approve_user)
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-6">
                            @if($po->status != 1 && auth()->user()->hasRole('developer'))
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12">
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
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-12 col-sm-6 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-info"><i class="fas fa-check-circle"></i> Approve PO</span>
                                <br>
                                @if($po->approve_user)
                                <span>{{$po->approve_user->name}}</span>
                                <br><span>เวลา {{$po->approve_user_time}}</span>
                                @else
                                <button type="button" class="btn btn-outline-info" onclick="approve('{{$po->id}}')">ผู้อนุมัติ</button>
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
<div class="row">
    <div class="col-12">
        <a href="/po/copy/{{$po->id}}"><button  type="button" class="btn w-auto btn-outline-success btn-sm float-right"><i class="fas fa-copy"></i> COPY PO</button></a>
    </div>
</div>
<br>
<br>
@endsection

@section('header')
@endsection

@section('footer')
<script>
    function sentApprove(id) {
        if (confirm('ยืนยัน ขออนุมัติ PO ?')) {
            location.href = "/po-nr/sent/" + id;
        }
    }

    function edit(id) {
        if (confirm('ยืนยัน แก้ไข PO ?')) {
            location.href = "/po-nr/edit/" + id;
        }
    }

    function cancle(id) {
        if (confirm('ยืนยัน ยกเลิก PO ?')) {
            location.href = "/po-nr/cancle/" + id;
        }
    }

    function approve(id) {
        if (confirm('ต้องการอนุมัติ ?')) {
            location.href = '/po-nr/approve/' + id;

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
            location.href = '/po-nr/reject/' + id + '/' + reject_note;

            history.replaceState({
                urlPath: '/po/show/approve/' + id
            }, "", '/')
        }
    }
</script>
@endsection