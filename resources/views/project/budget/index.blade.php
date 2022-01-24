@extends('master')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">แผนต้นทุนโครงการ</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">แผนต้นทุนโครงการ</li>
        </ol>
      </div>
    </div>
  </div>
</div>


@if(!$project->cost_plans()->exists())
<div class="container-fluid">
  @include('project.heade')
  <div class="row">
    <div class="col-md-3 col-sm-6 col-12">
    </div>
    <div class="col-md-3 col-sm-6 col-12">
    </div>
    <div class="col-md-3 col-sm-6 col-12">
    </div>
    <div class="col-md-3 col-sm-6 col-12">
      <a href="/project/detail/budget/{{$project->id}}/create">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fa fa-plus"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">ยังไม่มีแผนต้นทุน</span>
            <span class="info-box-number">เพิ่มแผนต้นทุน</span>
          </div>
        </div>
      </a>
    </div>

  </div>
</div>
@else
<div class="container-fluid">
  @include('project.heade')
  <div class="card">
    <div class="card-body" style="background-color: #ddd;">
      <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
          <div class="card">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <h3 class="card-title">แผนต้นทุน / ต้นทุนจริง</h3>
                <a class="text-warning" href="/project/detail/budget/{{$project->id}}/edit"><i class="fa fa-edit"></i> </a>
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex">
                <p class="d-flex flex-column">
                  <span class="text-bold text-lg text-primary">{{number_format($project->cost_plans->sum('cost'),2)}}</span>
                  <span>แผนต้นทุนรวม</span>
                </p>
                <p class="ml-auto d-flex flex-column text-right">
                  <span class="text-danger">
                    {{number_format($project->cost_plans->sum('use_cost'),2)}}
                  </span>
                  <span class="text-muted"> ต้นทุนที่ใช้รวม</span>
                </p>
              </div>
              <!-- /.d-flex -->

              <div class="position-relative mb-4">
                <canvas id="sales-chart" height="200"></canvas>
              </div>

              <div class="d-flex flex-row justify-content-end">
                <span class="mr-2">
                  <i class="fas fa-square text-primary"></i> แผนต้นทุน
                </span>

                <span>
                  <i class="fas fa-square text-danger"></i> ต้นทุนที่ใช้
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-1">
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">รายการแผนต้นทุน</h3>
    </div>
    <div class="card-body">
      <div class="row">
        @foreach($costplans as $i => $costplan)
        <div class="col-md-12">
          <div class="card collapsed-card">
            <div class="card-header">
              <h5 class="card-title">
                @if($i == 0 )
                <i class="fa fa-cart-plus fa-2x text-success"></i>
                @elseif($i == 1)
                <i class="fa fa-child fa-2x text-info"></i>
                @elseif($i == 2)
                <i class="fa fa-wrench fa-2x text-primary"></i>
                @elseif($i == 3)
                <i class="fa fa-drupal fa-2x text-warning"></i>
                @else
                <i class="fa fa-shopping-bag fa-2x text-danger"></i>
                @endif
                {{$i + 1}} . {{$costplan->name}} <small>@if($costplan->note)({{$costplan->note}})@endif</small></h5>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="display: none;">
              <div class="card-body p-0">
                <table class="table table-sm table-bordered">
                  <thead bgcolor="#7E7E7E">
                    <tr class="text-center">
                      <th>รหัสต้นทุน</th>
                      <th>ประเภท</th>
                      <th>รายละเอียด</th>
                      <th>แผนต้นทุน</th>
                      <th>ต้นทุนที่ใช้</th>
                      <th>ส่วนต่าง</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($project->cost_plans()->where('cost_plan_id', $costplan->id)->get() as $i => $cost_plan)
                    <tr>
                      <td>
                        <p class="mb-0 mt-2 mr-2">{{$cost_plan->cost_plan_list->code}}</p>
                      </td>
                      <td>
                        <p class="mb-0 mt-2 mr-2">{{$cost_plan->cost_plan_list->name}}</p>
                      </td>
                      <td>
                        <p class="mb-0 mt-2 mr-2">{{$cost_plan->note}}</p>
                      </td>
                      <td class="text-right">
                        <p class="mb-0 mt-2 mr-2">{{ number_format($cost_plan->cost,2)}}</p>
                      </td>
                      <td class="text-right">
                        <p class="mb-0 mt-2 mr-2 text-danger">{{ number_format($cost_plan->use_cost,2)}}</p>
                      </td>
                      <td class="text-right">
                        @if($cost_plan->cost > 0)<p class="mb-0 mt-2 mr-2 @if($cost_plan->cost > $cost_plan->use_cost) text-success @else text-danger @endif"> {{ number_format($cost_plan->cost - $cost_plan->use_cost,2)}}</p>@endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        @endforeach

        <!-- /.col -->
      </div>
    </div>
  </div>
</div>
@endsection
@section('footer')

<script>
  $(function() {
    $('.inputNum').on('click keyup', sumMoney);

    function sumMoney() {
      var sum = 0;
      $('.inputNum').each(function() {
        if (this.value) {
          sum += parseFloat(this.value);
        }
      });

      $('#sumCost').val(sum);
    }

  });
</script>
<script>
  $(function() {
    'use strict'

    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }

    var mode = 'index'
    var intersect = true

    var $salesChart = $('#sales-chart')
    var salesChart = new Chart($salesChart, {
      type: 'bar',
      data: {
        labels: [
          '{{$as[0]}}', '{{$as[1]}}', '{{$as[2]}}', '{{$as[3]}}', '{{$as[4]}}'
        ],
        datasets: [{
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: [
              '{{$bs[0]}}', '{{$bs[1]}}', '{{$bs[2]}}', '{{$bs[3]}}', '{{$bs[4]}}'
            ]
          },
          {
            backgroundColor: '#EC4040',
            borderColor: '#EC4040',
            data: [
              '{{$cs[0]}}', '{{$cs[1]}}', '{{$cs[2]}}', '{{$cs[3]}}', '{{$cs[4]}}'
            ]
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'k'
                }
                return '฿ ' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
  })
</script>
@endif
@endsection