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
                </div>
            </div>
        </div>
    </div>
</div>

@include('po.head_po')
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
        <form action="/new-allocate" method="get" onsubmit="return confirm('ยืนยันจัดสรรต้นทุน ?')">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">รายการสั่งซื้อ</h3>
                    <div class="card-tools">
                        @include('po.allocate_detail')
                        <button type="submit" class="btn btn-outline-info btn-sm w-auto">จัดสรรต้นทุน</button>
                    </div>
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
                                    @if($po->status == 0)
                                    <th> 
                                        <label>
                                            <input type="checkbox"  name="css_all_check" id="css_all_check"> 
                                            จัดสรรต้นทุน
                                         </label>
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($po->purchaseOrderLists as $i => $list)
                                <tr class="text-center">
                                    <td>{{$i + 1}}</td>
                                    <td>
                                        <small>
                                        @if($list->allocate)
                                        @foreach($list->allocate->allocate_list as $no => $allocate_list)
                                        {{$allocate_list->project_cost_plan_list->cost_plan_list->code}}: {{$allocate_list->project_cost_plan_list->cost_plan_list->name}}
                                        @if($no < $list->allocate->allocate_list->count() - 1)
                                            ,
                                            @endif
                                            @endforeach
                                            @else
                                            ยังไม่จัดสรรต้นทุน
                                            @endif
                                        </small>
                                    </td>
                                    <td>{{$list->name}}</td>
                                    <td>{{$list->amount}}</td>
                                    <td>{{$list->unit}}</td>
                                    <td>{{number_format($list->unit_price, 3)}}</td>
                                    <td>{{number_format($list->unit_discount, 2)}}</td>
                                    <td>{{number_format($list->special_discount, 2)}}</td>
                                    <td>{{number_format($list->price, 2)}}</td>
                                    @if($po->status == 0)
                                    <td>
                                        @if(!$list->allocate)
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" name="po_lists_id[]" value="{{$list->id}}" id="checkboxPrimary{{$i}}" class="allcheck">
                                                <label for="checkboxPrimary{{$i}}">
                                                    เลือก
                                                </label>
                                            </div>
                                        </div>
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
                    <br>
                    <div class="row">
                        <div class="col-12 col-md-6">
                        <div class="form-group">
                            <a data-toggle="modal" data-target="#showListImage" style="cursor: zoom-in;">
                                <i class="fa fa-picture-o"></i>
                            </a>
                            <span>ไฟล์ :
                                @foreach($po->poFiles as $no => $pofile)
                                <a href="#" data-toggle="modal" data-target="#showListImage" >
                                     <span class="img-fluid mb-2" >ไฟล์ {{$no + 1}}</span> 
                                </a>
                                @endforeach
                            </span>

                            <div class="modal fade " id="showListImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-eye"></i> เลือกดูทีละไฟล์ </h5>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                        @foreach($po->poFiles as $no => $pofile)  
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home-{{$no}}" role="tab" aria-controls="custom-content-below-home-{{$no}}" aria-selected="false">ไฟล์ {{$no + 1}}</a>
                                            </li>
                                        @endforeach
                                        </ul>
                                        <div class="tab-content text-center" id="custom-content-below-tabContent">
                                            @foreach($po->poFiles as $no => $pofile)
                                                <div class="tab-pane fade" id="custom-content-below-home-{{$no}}" role="tabpanel" aria-labelledby="custom-content-below-home-{{$no}}-tab">
                                                @if(collect(explode('.', $pofile->file))[1] == 'jpeg' || collect(explode('.', $pofile->file))[1] == 'png' || collect(explode('.', $pofile->file))[1] == 'jpg')
                                                <a target="bank" href="/storage/{{ $pofile->file }}"><img class="img-fluid pad" src="/storage/{{ $pofile->file }}" alt="Photo"></a>
                                                @elseif(collect(explode('.', $pofile->file))[1] == 'pdf')
                                                <iframe class="text-right" src="/storage/{{ $pofile->file }}" height="400px" width="100%"></iframe>
                                                @else
                                                <a target="bank" href="/storage/{{ $pofile->file }}">
                                                <div class="info-box m-3 bg-success">
                                                    <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Downloads</span>
                                                        <span class="info-box-number">{{ collect(explode('.', $pofile->file))[1] }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                </a>
                                                @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
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
                            <div class="form-group">
                                <span>SPECIAL DISCOUNT : <span style="text-decoration: underline gray;">{{number_format($po->special_discount, 2)}}</span></span>
                            </div>
                            @if($po->vat_type == 'นอก' || $po->vat_type == 'ใน')
                            <div class="form-group">
                                <span>TAX BASE : <span style="text-decoration: underline gray;">{{number_format($po->sum_price, 2)}}</span></span>
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
                                <span>GRAN TOTAL : <span style="text-decoration: underline gray;">{{number_format($po->vat_amount + $po->sum_price, 2)}}</span></span>
                            </div>
                        </div>
                    </div>

                    <br>
                </div>
            </form>
            @include('po.footer_po')
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
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/ekko-lightbox/ekko-lightbox.css">
@endsection

@section('footer')
<script>
    function approve(id) {
        if (confirm('ต้องการอนุมัติ ?')) {
            location.href = '/po/approve/' + id;
        }
    }

    function sentApprove(id) {
        if (confirm('ยืนยัน ขออนุมัติ PO ?')) {
            location.href = "/po/sent/" + id;
        }
    }

    function edit(id) {
        if (confirm('ยืนยัน แก้ไข PO ?')) {
            location.href = "/po/edit/" + id;
        }
    }

    function cancle(id) {
        if (confirm('ยืนยัน ยกเลิก PO ?')) {
            location.href = "/po/cancle/" + id;
        }
    }

    function reject(id) {
        var reject_note = document.getElementById('reject_note').value;
        if(!reject_note){
            alert('กรอกข้อมูลให้ครบถ้วน');
            return;
        }
        if (confirm('ไม่อนุมัติ ?')) {
            location.href = '/po/reject/' + id + '/' + reject_note;
        }
    }
</script>

<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
<!-- Ekko Lightbox -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>
@endsection