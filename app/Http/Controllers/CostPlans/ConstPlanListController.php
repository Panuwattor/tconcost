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
            $request = request()->all();
            $list_count = CostPlanList::where('cost_plan_id', request('cost_plan_id'))->count();

            $code = request('cost_plan_id') . sprintf("%'03d", ($list_count + 1));
            $request['code'] = $code;
            CostPlanList::create($request);
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
