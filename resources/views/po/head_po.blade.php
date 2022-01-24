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
                    <span>โครงการ : <span style="text-decoration: underline gray;">{{$po->project->name}}</span> <a href="/project/show/{{$po->project_id}}" target="back"><i class="fa fa-eye"></i></a></span>
                </div>
                <div class="form-group">
                    <span>ผู้ขาย : <span style="text-decoration: underline gray;">{{$po->supplier->name}}</span> <a href="/customer/{{$po->supplier->id}}/show" target="back"><i class="fa fa-eye"></i></a></span>
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
        @if($po->status == 3) 
            <a href="/po/reject/edit/{{$po->id}}">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-edit"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-number">ขออนุมัติใหม่</span>
                        <span class="info-box-text">แก้ไข {{$po->code}}</span>
                    </div>
                </div>
             </a>
        @endif
        @if($po->status == 4) 
         @if(!$po->new_po)
        <!-- <a href="/po/reject/create/new/{{$po->id}}">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-refresh"></i></span>
                <div class="info-box-content">
                    <span class="info-box-number">ขออนุมัติใหม่</span>
                    <span class="info-box-text">คัดลอก {{$po->code}}</span>
                </div>
            </div>
        </a> -->
        @else
         <a href="/po/show/{{$po->new_po->new_po->id}}"> 
         <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-clipboard"></i></span>
                <div class="info-box-content">
                    <span class="info-box-number">New</span>
                    <span class="info-box-text">{{$po->new_po->new_po->code}}</span>
                </div>
            </div>
        </a>
        @endif
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ข้อมูลที่อยู่จัดส่ง</h3>
            </div>
            <div class="card-body row">
                <div class="col-12 col-md-6">
                <div class="form-group">
                    <span>ผู้ดูแล : <span style="text-decoration: underline gray;">{{$po->main_user->name}}</span></span>
                </div>
                <div class="form-group">
                    <span>เบอร์โทร : <span style="text-decoration: underline gray;">{{$po->tel}}</span></span>
                </div>
                </div>
                <div class="col-12 col-md-6">

                <div class="form-group">
                    <span>ที่อยู่ : <span style="text-decoration: underline gray;">{{$po->address}}</span></span>
                </div>
                </div>

            </div>
        </div>
        <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <a href="/po/show/{{$po->id}}/logs" class="btn btn-tool text-info btn-sm">
                            <i class="fas fa-bars"></i> ทั้งหมด
                        </a>
                    </div>
                    <h3 class="card-title"><i class="fa fa-floppy-o"></i> Logs บันทึกการทำงาน</h3>
                </div>
                <div class="card-body p-0">
                <table class="table table-bordered table-sm">
                  <thead>                  
                    <tr class="text-center">
                      <th style="width: 10px">#</th>
                      <th>user</th>
                      <th>type</th>
                      <th>note</th>
                      <th>time</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($po->logs()->with('user')->orderBy('created_at','desc')->limit(5)->get() as $no=>$log)
                    <tr class="text-center">
                      <td>{{$no+1}}</td>
                      <td>{{$log->user->name}}</td>
                      <td> <a href="{{$log->link}}" target="back"> {{$log->type}}</a></td>
                      <td>{{$log->note}}</td>
                      <td>{{$log->created_at}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                </div>
            </div>
    </div>
</div>