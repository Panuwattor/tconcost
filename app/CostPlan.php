<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostPlan extends Model
{
    protected $fillable = ['name', 'note' , 'branch_id' ,'count_cost'];

    function costPlanLists(){
        return $this->hasMany('App\CostPlanList', 'cost_plan_id');
    }

    function branch(){
        return $this->belongsTo(\App\Branch::class, 'branch_id');
    }
}
