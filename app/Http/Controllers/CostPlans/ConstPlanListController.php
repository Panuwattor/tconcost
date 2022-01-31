<?php

namespace App\Http\Controllers\CostPlans;

use App\CostPlan;
use App\CostPlanList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConstPlanListController extends Controller
{
    public function create()
    {
        DB::transaction(function(){
            $list_count = CostPlanList::where('cost_plan_id', request('cost_plan_id'))->where('branch_id',auth()->user()->branch_id)->count();
            $cost_plan = CostPlan::find(request('cost_plan_id'));
            $code = $cost_plan->count_cost . sprintf("%'03d", ($list_count + 1));
            CostPlanList::create([
                'cost_plan_id'=> request('cost_plan_id'),
                'name'=> request('name'),
                'note'=> request('note'),
                'code'=> $code,
                'branch_id'=>auth()->user()->branch_id
            ]);
        });

        return back();
    }
    
    public function update(CostPlanList $costplan_list)
    {
        DB::transaction(function() use ($costplan_list){
            if(CostPlanList::whereNotIn('id',[$costplan_list->id])->where('code',request('code'))->exists()){
                alert()->error('ผิดพลาด', 'มี Code ซ้ำ');
                return back();
            }
            $costplan_list->update(request()->all());
        });

        return back();
    }
}
