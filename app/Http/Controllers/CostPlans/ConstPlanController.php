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
        $costplans = CostPlan::all();
        $costplanlists = CostPlanList::orderBy('cost_plan_id', 'asc')->with('cost_plan')->get();
        
        return view('costplans.index', compact('costplans', 'costplanlists'));
    }

    public function store()
    {
        CostPlan::create(request()->all());
        return back();
    }

    public function update(CostPlan $costplan)
    {
        DB::transaction(function() use ($costplan){
            $costplan->update(request()->all());
        });

        return back();
    }
}
