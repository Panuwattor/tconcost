<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WhtList extends Model
{
    protected $fillable = ['wht_id','accounting_id','article','note','amount','rate','wht_tax', 'wht_group_id'];

    function account(){
        return $this->belongsTo(\App\Account::class, 'accounting_id');
    }

    function group(){
        return $this->belongsTo(\App\WhtGroup::class, 'wht_group_id');
    }
}
