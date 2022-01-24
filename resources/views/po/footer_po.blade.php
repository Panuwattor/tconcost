@if($po->status == 0)
<div class="card-footer">
    <div class="row">
        <div class="col-12 col-sm-6 col-6">
            <div class="description-block border-right border-left" data-toggle="modal" data-target="#modal-default">
                <span class="description-percentage text-danger"><i class="fas fa-close"></i> Reject PO</span>
                <br>
                <form id="app" action="/po/cancel/{{$po->id}}" method="post" enctype="multipart/form-data" onsubmit="return confirm('ยืนยัน  ยกเลิก ?')">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">ยกเลิก</button>
                </form>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-6">
            <div class="description-block border-right">
                <span class="description-percentage text-info"><i class="fas fa-check-circle"></i> Approve PO</span>
                <br>
                <form id="app" action="/po/approve/{{$po->id}}" method="post" enctype="multipart/form-data" onsubmit="return confirm('ยืนยัน ข้อมูลถูกต้อง ?')">
                    @csrf
                    <button type="submit" class="btn btn-outline-info">ผู้อนุมัติ</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif