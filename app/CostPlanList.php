<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostPlanList extends Model
{
    protected $fillable = ['cost_plan_id', 'name', 'note', 'code'];

    function cost_plan(){
        return $this->belongsTo('App\CostPlan', 'cost_plan_id');
    }
}
