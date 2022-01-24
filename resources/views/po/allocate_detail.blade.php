<button type="button" class="btn btn-outline-success btn-sm w-auto" data-toggle="modal" data-target="#allocate_detail">รายละเอียดการจัดสรร</button>
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
                        @foreach($po->purchaseOrderLists as $i => $po_list)
                        @if($po_list->allocate)
                        @foreach($po_list->allocate->allocate_list as $list)
                        <tr>
                            <td>สั่งซื้อ {{$po_list->name}}</td>
                            <td>
                                {{$list->project->name}}
                            </td>
                            <td>
                                {{$list->project_cost_plan_list->cost_plan->name}} / {{$list->project_cost_plan_list->cost_plan_list->name}}
                            </td>
                            <td>
                                ใช้ {{number_format($list->price, 2)}} บาท
                            </td>
                            <td>
                                เหลือ @if($list->project_cost_plan_list->cost - $list->project_cost_plan_list->use_cost >= 0) <span class="text-success">@else <span class="text-danger"> @endif {{number_format($list->project_cost_plan_list->cost - $list->project_cost_plan_list->use_cost, 2)}}</span>  บาท
                            </td>
                        </tr>
                        @endforeach
                        @endif
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