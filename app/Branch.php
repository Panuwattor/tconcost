<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'address', 'tel', 'tax', 'note','company','company_eng','logo','code','tax_code','status'];

    function to_users(){
        return $this->hasMany('App\UserToBranch', 'branch_id');
    }
    function cost_plans(){
        return $this->hasMany(\App\CostPlan::class, 'branch_id');
    }
}
