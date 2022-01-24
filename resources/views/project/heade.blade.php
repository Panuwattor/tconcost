<div class="row">
        <div class="col-md-4">
            <a href="/project/show/{{$project->id}}">
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fa fa-home"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">ข้อมูลโครงการ</span>
                    <span class="info-box-number">{{$project->code}} </span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                    {{$project->name}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            </a>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
            <a href="/project/detail/budget/{{$project->id}}">
                <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="fa fa-database"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">แผนต้นทุน</span>
                        @if($project->cost_plans()->exists())
                        <span class="info-box-number text-right"> 
                            <small class="pull-left">แผนต้นทุน</small> {{number_format($project->cost_plans->sum('cost'), 2)}}
                        </span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description text-right">
                            <small class="pull-left">ต้นทุนที่ใช้</small>  {{number_format($project->cost_plans->sum('use_cost'), 2)}}
                        </span>
                        @endif

                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        </div>
        <!-- /.col -->
        <div class="col-md-4">
            <a href="/project/add-income/new/{{$project->id}}">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fa fa-list-ul"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">แผนรายรับ {{number_format($project->project_cost, 2)}} บาท</span>
                        @if($project->incomes()->exists())
                        <span class="info-box-number text-right">  <small class="pull-left">แผนจริง</small> {{number_format($project->incomes->sum('total'), 2)}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: @if($project->incomes->where('status',1)->sum('total') > 0) {{($project->incomes->where('status',1)->sum('total') * 100) / $project->incomes->sum('total') }} @else 0 @endif%"></div>
                        </div>
                        <span class="progress-description text-right">
                           <small class="pull-left">รับจริง</small>  {{number_format($project->incomes->where('status',1)->sum('total'), 2)}}
                        </span>
                        @endif
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
        </div>
    </div>