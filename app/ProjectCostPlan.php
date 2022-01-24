<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCostPlan extends Model
{
    protected $fillable = ['project_id','cost_plan_id','cost_plan_list_id','cost','use_cost','note'];
    
    function project(){
        return $this->belongsTo(\App\Project::class, 'project_id');
    }

    function cost_plan(){
        return $this->belongsTo(\App\CostPlan::class, 'cost_plan_id');
    }

    function cost_plan_list(){
        return $this->belongsTo(\App\CostPlanList::class, 'cost_plan_list_id');
    }
}
