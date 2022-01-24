<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllocateList extends Model
{
    protected $fillable = ['allocate_id', 'project_id', 'project_cost_plan_list_id', 'price'];

    function allocate(){
        return $this->belongsTo('App\Allocate', 'allocate_id');
    }

    function project(){
        return $this->belongsTo('App\Project', 'project_id');
    }

    function project_cost_plan_list(){
        return $this->belongsTo(\App\ProjectCostPlan::class, 'project_cost_plan_list_id');
    }
}
