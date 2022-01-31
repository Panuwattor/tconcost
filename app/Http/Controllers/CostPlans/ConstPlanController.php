<?php

namespace App\Http\Controllers\CostPlans;

use App\CostPlan;
use App\CostPlanList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ConstPlanController extends Controller
{
    public function index()
    {
        $costplans = CostPlan::where('branch_id', auth()->user()->branch_id)->get();
        $costplanlists = CostPlanList::orderBy('cost_plan_id', 'asc')->with('cost_plan')->get();

        return view('costplans.index', compact('costplans', 'costplanlists'));
    }

    public function store()
    {
        $costplan = CostPlan::where('branch_id', auth()->user()->branch_id)->count();
        CostPlan::create([
            'count_cost' => $costplan + 1,
            'name' => request('name'),
            'note' => request('note'),
            'branch_id' => auth()->user()->branch_id
        ]);
        return back();
    }

    public function update(CostPlan $costplan)
    {
        DB::transaction(function () use ($costplan) {
            $costplan->update(request()->all());
        });

        return back();
    }

    public function create_auto()
    {
        $costplan = CostPlan::where('branch_id', auth()->user()->branch_id)->count();
        if($costplan > 0){
            alert()->error('ผิดพลาด', 'มีกลุ่มต้นทุนแล้ว');
            return back();
        }
        DB::transaction(function () {

            foreach (config('costplan.cost_plans') as $no => $cost_plan) {
                $costplan = CostPlan::where('branch_id', auth()->user()->branch_id)->count();
                $cost_plan = CostPlan::create([
                    'count_cost' => $costplan + 1,
                    'name' => $cost_plan,
                    'note' => Null,
                    'branch_id' => auth()->user()->branch_id
                ]);
                foreach (config('costplan.cost_plan_lists' . $no) as $key => $list) {
                    $cost_plan->costPlanLists()->create([
                        'name' => $list,
                        'note' => Null,
                        'code' => $key,
                        'branch_id' => auth()->user()->branch_id
                    ]);
                }
            }
        });

        return back();
    }
}
