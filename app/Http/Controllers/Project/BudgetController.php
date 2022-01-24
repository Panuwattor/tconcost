<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CostPlan;
use App\Project;
use App\CostPlanList;
use App\ProjectCostPlan;
use DB;

class BudgetController extends Controller
{

    public function index(Project $project)
    {
        $costplans = CostPlan::all();

        $sumCostPlans = ProjectCostPlan::select('cost_plan_id', DB::raw('SUM(cost) as sum_cost,SUM(use_cost) as sum_use_cost'))
                                    ->groupBy('cost_plan_id')
                                    ->where('project_id',$project->id)
                                    ->get();
        $as = [];
        $bs = [];
        $cs = [];
        foreach($sumCostPlans as $sumCostPlan){
            $as[] = $sumCostPlan->cost_plan->name;
            $bs[] = $sumCostPlan->sum_cost;
            $cs[] = $sumCostPlan->sum_use_cost;
        }
        return view('project.budget.index', compact('project','costplans','as','bs','cs'));
    }

    public function edit(Project $project)
    {
        $costplans = CostPlan::all();
        return view('project.budget.edit', compact('project', 'costplans'));
    }
    
    public function addcost(Project $project)
    {
        $costplans = CostPlan::all();
        return view('project.budget.create', compact('project', 'costplans'));
    }

    public function addcost_store(Project $project)
    {
        DB::transaction(function () use($project){
            $project->cost_plans()->delete();
            foreach(request('costs') as $key=>$cost){
                $list = CostPlanList::find($key);
                $project->cost_plans()->create([
                  'cost_plan_id'=>$list->cost_plan_id,
                  'cost_plan_list_id'=>$list->id,
                  'cost'=>$cost ?: 0,
                  'use_cost'=>0,
                  'note'=>request('descriptions')[$key]
                ]);
                
              }
              $pro = $project->incomes()->exists();
              $pro = $project->cost_plans()->exists();
              if($pro){
               $project->update([
                   'status'=>1
               ]);
              }
        });

        alert()->success('ทำรายการสำเร็จ', 'เรียบร้อย');
        return redirect('/project/detail/budget/'.$project->id);
    }

    public function update(Project $project)
    {

        DB::transaction(function () use($project){
            foreach(request('costs') as $key=>$cost){
                $cost_plan = ProjectCostPlan::find($key);
                $cost_plan->update([
                  'cost'=>$cost ?: 0,
                  'note'=>request('descriptions')[$key]
                ]);
                
              }
        });

        alert()->success('ทำรายการสำเร็จ', 'เรียบร้อย');
        return redirect('/project/detail/budget/'.$project->id);
    }
    
}
