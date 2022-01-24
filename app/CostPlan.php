<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostPlan extends Model
{
    protected $fillable = ['name', 'note'];

    function costPlanLists(){
        return $this->hasMany('App\CostPlanList', 'cost_plan_id');
    }
}
