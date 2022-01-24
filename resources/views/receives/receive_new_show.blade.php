@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">รับของ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/receive">รายการรับของ</a></li>
                    <li class="breadcrumb-item active">รับของ</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
         <div class="card-tools">
            <a href="/receive-waiting-approve/show/{{$receive->id}}/print" target="back_"><button type="button" class="btn btn-outline-secondary"><i class="fa fa-print"></i> พิมพ์</button> </a>
            @if($receive->status == 0)
            <a href="/receive/update/{{$receive->id}}"><button type="button" class="btn btn-outline-warning"><i class="fa fa-edit"></i> แก้ไข</button> </a>
            @endif
            @if($receive->status == 2)
            <a href="/receive/approve/update/{{$receive->id}}"><button type="button" class="btn btn-outline-warning"><i class="fa fa-edit"></i> แก้ไข</button> </a>
            @endif
        </div>
        <h3 class="card-title">สถานะ {!!$receive->receivestatus!!}</h3>
    </div>
    <div class="card-body table-responsive">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>Receive id</label>
                            <br><span class="text-secondary">{{$receive->receive_code}}</span>
                        </div>
                        <div class="form-group">
                            <label>โครงการ</label>
                            <br><span class="text-secondary">{{$receive->project->name}}</span>
                        </div>
                        <div class="form-group">
                            <label>สาขา</label>
                            <br><span class="text-secondary">{{$receive->project->branch->name}}</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>ผู้ขาย</label>
                            <br><span class="text-secondary">{{$receive->supplier->name}}</span>
                        </div>
                        <div class="form-group">
                            <label>วันที่</label>
                            <br><span class="text-secondary">{{$receive->date}}</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 col-md-4"></div>
                    <div class="col-12 col-md-8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="border-top: 0px solid #dee2e6" colspan="2">Reference</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        PO NO.
                                        <br><a href="/po/show/{{$receive->po->id}}">{{$receive->po->po_id}}</a>
                                    </td>
                                    <td>
                                        DATE
                                        <br>{{$receive->po->po_date}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        PO AMOUNT.
                                        <br>
                                        {{number_format($receive->po->sum_price,2)}}
                                    </td>
                                    <td>
                                        PO REMAIN
                                        <br>
                                        {{number_format($receive->po_remain,2)}}
                                        <span>({{$receive->po_remain_percent}}%)</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                @if($receive->receive_files->count() > 0)
                <div class="card-header">
                    <div class="form-group">
                             <a data-toggle="modal" data-target="#showListImage" style="cursor: zoom-in;">
                                <i class="fa fa-picture-o"></i>
                            </a>
                        <span>ไฟล์ :
                                @foreach($receive->receive_files as $no => $file)
                                <a href="#" data-toggle="modal" data-target="#showListImage" style="cursor: zoom-in;">
                                     <span class="img-fluid mb-2" >ไฟล์ {{$no + 1}}</span> 
                                </a>
                                @endforeach
                            </span>
                    </div>
                    <div class="modal fade " id="showListImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-eye"></i> เลือกดูทีละไฟล์ </h5>
                            </div>
                            <div class="modal-body">
                                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                @foreach($receive->receive_files as $no => $pofile)  
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home-{{$no}}" role="tab" aria-controls="custom-content-below-home-{{$no}}" aria-selected="false">ไฟล์ {{$no + 1}}</a>
                                    </li>
                                @endforeach
                                </ul>
                                <div class="tab-content text-center" id="custom-content-below-tabContent">
                                    @foreach($receive->receive_files as $no => $pofile)
                                        <div class="tab-pane fade" id="custom-content-below-home-{{$no}}" role="tabpanel" aria-labelledby="custom-content-below-home-{{$no}}-tab">
                                        @if( count(collect(explode('.', $pofile->file))) > 1 && (collect(explode('.', $pofile->file))[1] == 'jpeg' || collect(explode('.', $pofile->file))[1] == 'png'))
                                        <a target="bank" href="{{ Storage::disk('spaces')->url($pofile->file) }}"><img class="img-fluid pad" src="{{ Storage::disk('spaces')->url($pofile->file) }}" alt="Photo"></a>
                                        @elseif( count(collect(explode('.', $pofile->file))) > 1 && collect(explode('.', $pofile->file))[1] == 'pdf')
                                        <iframe class="text-right" src="{{ Storage::disk('spaces')->url($pofile->file) }}" height="400px" width="100%"></iframe>
                                        @else
                                        <a target="bank" href="{{ Storage::disk('spaces')->url($pofile->file) }}"><img class="img-fluid pad" src="{{ Storage::disk('spaces')->url($pofile->file) }}" alt="Photo"></a>

                                        <!-- <a target="bank" href="{{ Storage::disk('spaces')->url($pofile->file) }}">
                                        <div class="info-box m-3 bg-success">
                                            <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Downloads</span>
                                                <span class="info-box-number">{{ collect(explode('.', $pofile->file)) }}</span>
                                            </div>
                                        </div>
                                        </a> -->
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
                @endif
            </div>
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
                    <th>ส่วนลดพิเศษ</th>
                    <th>จำนวนเงิน</th>
                </tr>
            </thead>
            <tbody>
                @foreach($receive->receive_lists as $index => $list)
                <tr class="text-center">
                    <td>{{$index + 1}}</td>
                    <td>{{$list->name}}</td>
                    <td>{{number_format($list->amount, 2)}}</td>
                    <td>{{$list->unit}}</td>
                    <td>{{number_format($list->unit_price, 3)}}</td>
                    <td>{{number_format($list->unit_discount, 2)}}</td>
                    <td>{{number_format($list->special_discount, 2)}}</td>
                    <td>{{number_format($list->price, 2)}}</td>
                </tr>
                @foreach($list->po_list->listNotes as $_note)
                <tr class="text-center" style="background-color: #f2f2f2;">
                    <td></td>
                    <td colspan="7">{{$_note->note}}</td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-12 col-md-6">
                @if($receive->duedate)
                <div class="card-header">
                    <div class="form-group">
                        <b>วันที่เริ่ม : </b> <span>{{$receive->duedate->start}}</span>
                        <b>วันที่สิ้นสุด : </b> <span>{{$receive->duedate->finish}}</span>
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <span>เงื่อนไขการชำระ : </span>
                    {{$receive->payment_condition}}
                </div>
                <div class="form-group">
                    <span>หมายเหตุ : </span>
                    {{$receive->note}}
                </div>
            </div>
            <?php
                $_retention = 0;
            ?>
            <div class="col-12 col-md-6 text-right">
                @if($receive->retention)
                <?php
                    $_retention = $receive->retention->price;
                ?>
                <div class="card-header">
                    <div class="form-group">
                        <label>เงินประกันผลงาน</label>
                        <span>{{number_format($receive->retention->price, 2)}}</span>
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <span>SPECIAL DISCOUNT : <span style="text-decoration: underline gray;">{{number_format($receive->special_discount,2)}}</span></span>
                </div>
                <div class="form-group">
                    <span>TAX BASE : <span style="text-decoration: underline gray;">{{number_format($receive->sum_price,2)}}</span></span>
                </div>
                <div class="form-group">
                    <span>
                        VAT :
                        <span style="text-decoration: underline gray;">
                            {{number_format($receive->vat_amount,2)}}
                        </span>
                    </span>
                </div>
                <div class="form-group">
                    <span>TOTAL : <span style="text-decoration: underline gray;">{{number_format(($receive->sum - $_retention),2)}}</span></span>
                </div>
            </div>
        </div>
        @if($receive->status == 0)
        <div class="row">
            <div class="col-12">
                <form action="/receive-approve" method="post" onsubmit="return confirm('ต้องการที่จะ อนุมัติ การรับของรายการนี้ ?')">
                    @csrf
                    <input type="hidden" name="receive_id" value="{{$receive->id}}">
                    <button type="submit" style="float: right; margin-left: 20px;" class="btn btn-outline-success btn-sm w-auto">อนุมัติ</button>
                </form>
                <button type="button" style="float: right;" class="btn btn-outline-danger btn-sm w-auto" data-toggle="modal" data-target="#reject">ไม่อนุมัติ</button>
            </div>
        </div>
        <div class="modal fade" id="reject">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">เหตุผลที่ไม่ อนุมัติ</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/receive-reject" method="post" onsubmit="return confirm('ต้องการที่จะ ไม่อนุมัติ การรับของรายการนี้ ?')">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="receive_id" value="{{$receive->id}}">
                            <textarea required name="reject_note" cols="30" rows="3" placeholder="Enther....." class="form-control"></textarea>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('header')
<style>
    [v-cloak]>* {
        display: none;
    }

    [v-cloak]::before {
        content: " ";
        display: block;
        position: absolute;
        width: 80px;
        height: 80px;
        background-image: url(http://pluspng.com/img-png/loader-png-indicator-loader-spinner-icon-512.png);
        background-size: cover;
        left: 50%;
        top: 50%;
    }
</style>
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/ekko-lightbox/ekko-lightbox.css">
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
@endsection