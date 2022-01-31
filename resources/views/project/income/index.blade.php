@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">แผนรายรับ โครงการ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/project/show/{{$project->id}}">โครงการ</a></li>
                    <li class="breadcrumb-item active">แผนรายรับ</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    @include('project.heade')

    @if(!$project->incomes()->exists())
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
        </div>
        <div class="col-md-3 col-sm-6 col-12">
        </div>
        <div class="col-md-3 col-sm-6 col-12">
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="/project/add-income/create/{{$project->id}}">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fa fa-plus"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">ยังไม่มีแผนรายรับ</span>
                        <span class="info-box-number">เพิ่มแผนรายรับ</span>
                    </div>
                </div>
            </a>
        </div>

    </div>
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="background-color: #ddd;">
                    <div class="row" >
                        <div class="col-md-1">
                        </div>
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                    <h3 class="card-title">เงินงวด / แผนรายรับ</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="position-relative mb-4">
                                    <canvas id="visitors-chart" height="200"></canvas>
                                    </div>

                                    <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                        <i class="fas fa-square text-primary"></i> แผนรายรับ
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-square text-danger"></i> ยอดสะสม
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">แผนรายรับโครงการ

                    </h3>

                    <div class="card-tools">
                        <a href="/project/add-income/edit/{{$project->id}}" class="btn btn-outline-secondary btn-sm"> <i class="fa fa-edit"></i> แก้ไข/เพิ่มเติม</a>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <form action="/project/invoice/create/{{$project->id}}" method="post">
                    @csrf
                    <div class="card-body p-0">
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>วันที่</th>
                                        <th>ประเภท</th>
                                        <th>รายละเอียด</th>
                                        <th>หน่วย</th>
                                        <th class="text-right">จำนวนเงิน</th>
                                        <th class="text-right">%</th>
                                        <th class="text-right">ส่วนลด</th>
                                        <th class="text-right">รวม</th>
                                        <th>note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->incomes as $income)
                                    <tr>
                                        <td class="text-center">
                                            @if($income->status != 0)
                                            <i class="fa fa-check-circle-o text-success fa-2x"></i>
                                            @else
                                            <div class="icheck-primary">
                                                <input type="checkbox" value="{{$income->id}}" name="incomes[]" id="check{{$income->id}}">
                                                <label for="check{{$income->id}}"></label>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="text-center">{{$income->date}}</td>
                                        <td class="text-center">{{$income->type}}</td>
                                        <td>{{$income->description}}</td>
                                        <td class="text-center">{{$income->unit}}</td>
                                        <td class="text-right">{{ number_format($income->price,2)}}</td>
                                        <td class="text-right">{{ number_format($income->percent,2)}}</td>
                                        <td class="text-right">{{ number_format($income->discount,2)}}</td>
                                        <td class="text-right">{{ number_format($income->total,2)}}</td>
                                        <td>{{$income->note}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer p-0">
                        <div class="mailbox-controls">
                            <button type="submit" class="btn b btn-outline-primary m-3">ออก ใบแจ้งหนี้</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                      ใบแจ้งหนี้
                    </h3>
                </div>
                <div class="card-body p-0">
                    <form action="/receipt-ar/create" method="POST" id="receipt_ar">
                        @csrf
                        <div class="table-responsive">
                            <table  class="table table-hover table-sm text-nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>
                                            <label>เลือก</label>
                                        </th>
                                        <th>AR Code</th>
                                        <th>วันที่</th>
                                        <th>ยอดรวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->invoices as $i => $invoice)
                                    <tr class="text-center">
                                        <td>
                                            @if($invoice->status == 0)
                                            <div class="form-group mb-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="select{{$i}}" name="invoices[]" value="{{$invoice->id}}">
                                                    <label for="select{{$i}}" class="custom-control-label"> {{$i + 1}} เลือก</label>
                                                </div>
                                            </div>
                                            @elseif($invoice->status == 99)
                                            <i class="fa fa-times-circle-o text-danger "></i>
                                            @else
                                            <i class="fa fa-check-circle-o text-success "></i>
                                            @endif
                                        </td>
                                        <td><a href="/project/invoice/show/{{$invoice->id}}"> {{$invoice->code}}</a></td>
                                        <td>{{$invoice->date}}</td>
                                        <td>
                                          {{ number_format($invoice->total,2)}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="mailbox-controls">
                                <button type="submit" class="btn btn-outline-info btn-sm">Create Receipt</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                <h3 class="card-title">ใบเสร็จรับเงิน/ใบกำกับ</h3>
                </div>
                <div class="card-body p-0">
                        <div class="table-responsive p-0">
                            <table class="table table-hover table-sm text-nowrap" >
                                <thead>
                                    <tr class="text-center">
                                        <th>ลำดับ</th>
                                        <th>Code</th>
                                        <th>วันที่</th>
                                        <th class="text-right">Remain</th>
                                        <th class="text-right">Receipt Amount</th>
                                        <th>ผู้ทำรายการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->receiptArs as $i => $receipt_ar)
                                    <tr @if($receipt_ar->status == 99) bgcolor="#FFD9D9" @endif>
                                        <td class="text-center">{{$i + 1}}</td>
                                        <td class="text-left"><a href="/receipt-ar/show/{{$receipt_ar->id}}">{{$receipt_ar->code}}</a>@if($receipt_ar->status == 99) <small class="text-danger"> (ถูกยกเลิก)</small> @endif</td>
                                        <td class="text-center">{{$receipt_ar->date}}</td>
                                        <td class="text-right">{{number_format($receipt_ar->remain, 2)}}</td>
                                        <td class="text-right">{{number_format($receipt_ar->receipt_amount, 2)}}</td>
                                        <td class="text-center">{{$receipt_ar->user->name}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

@endsection

@section('header')
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection

@section('footer')
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    $(function() {
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });
    $(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

  var $visitorsChart = $('#visitors-chart')
  var visitorsChart  = new Chart($visitorsChart, {
    data   : {
      labels  :  {!! $aas !!},
      datasets: [{
          type                : 'line',
          data                : {!! $ats !!},
          backgroundColor     : 'tansparent',
          borderColor         : '#FF1313',
          pointBorderColor    : '#FF1313',
          pointBackgroundColor: '#FF1313',
          fill                : false
          // pointHoverBackgroundColor: '#ced4da',
          // pointHoverBorderColor    : '#ced4da'
        },{
        type                : 'line',
        data                : {!! $abs !!},
        backgroundColor     : 'transparent',
        borderColor         : '#007bff',
        pointBorderColor    : '#007bff',
        pointBackgroundColor: '#007bff',
        fill                : false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }

      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero : true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })
})
</script>

@endsection