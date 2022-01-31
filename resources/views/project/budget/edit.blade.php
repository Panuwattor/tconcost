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

<div class="container-fluid">
@include('project.heade')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">แก้ไข รายการแผนต้นทุน</h3>
        </div>
        <div class="card-body" style="background-color: #FFD88B;">
        <form action="/project/detail/budget/{{$project->id}}/update" method="post"  onSubmit="if(!confirm('ยืนยัน การทำรายการ หรือ ไม่ ?')){return false;}">
         @csrf
        <div class="row">
        @foreach($costplans as $i => $costplan)
          <div class="col-md-12">
            <div class="card collapsed-card">
            <a href="#" class="btn btn-tool" data-card-widget="collapse">
              <div class="card-header m-2">
              <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
                <h5 class="text-primary"> <i class="fa fa-cogs"></i>  {{$i + 1}} . {{$costplan->name}} <small>@if($costplan->note)({{$costplan->note}})@endif</small></h5>
              </div>
              </a>
              <!-- /.card-header -->
              <div class="card-body" style="display: none;">
              <div class="card-body p-0">
                <table class="table table-sm table-bordered">
                  <thead bgcolor="#7E7E7E">
                    <tr class="text-center">
                      <th>รหัสต้นทุน</th>
                      <th>ประเภท</th>
                      <th>รายละเอียด</th>
                      <th>จำนวนเงิน (ไม่รวม VAT)</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($project->cost_plans()->where('cost_plan_id', $costplan->id)->get() as $i => $cost_plan)
                    <tr>
                      <td><p class="mb-0 mt-2 mr-2">{{$cost_plan->cost_plan_list->code}}</p> </td>
                      <td><p class="mb-0 mt-2 mr-2">{{$cost_plan->cost_plan_list->name}}</p> </td>
                      <td>
                         <input class="form-control rounded-0 border-0 shadow-none placeholder-Desription ng-untouched ng-pristine ng-valid ng-star-inserted" value="{{$cost_plan->note}}" name="descriptions[{{$cost_plan->id}}]" type="text" placeholder=" เพิ่มรายละเอียดรหัสต้นทุน ">
                      </td>
                      <td><input class="form-control rounded-0 text-right border-0 shadow-none inputNum" value="{{$cost_plan->cost}}" name="costs[{{$cost_plan->id}}]" type="number" step="any" placeholder="0.00"></td>
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


                <br>
                <div class="row">
                    <div class="col-12 col-md-4"></div>
                    <div class="col-12 col-md-4"></div>
                    <div class="col-12 col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa fa-money"></i></span>

                            <div class="info-box-content">
                                <h5>จำนวนเงิน</h5>
                                <input type="text" class="form-control is-valid" id="sumCost" name="sumCost" value="{{$project->cost_plans->sum('cost')}}" readonly>
                            </div>
                            <button type="submit" class="btn btn-block btn-outline-success w-auto" style="float: right;">บันทึก</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('footer')

  <script>
    $(function(){
      $('.inputNum').on('click keyup', sumMoney);

      function sumMoney()
      {
        var sum = 0;
        $('.inputNum').each(function(){
            if(this.value){
                sum += parseFloat(this.value);
            }
        });

        $('#sumCost').val(sum);
      }

    });

  </script>

@endsection

