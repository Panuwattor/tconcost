<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AskPrice extends Model
{
    protected $fillable = ['ap_id','project_id','main_user_id','tel','delivery','ap_date','finish_date','address','photo','note','user_id','status'];

    function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    function main_user()
    {
        return $this->belongsTo('App\User', 'main_user_id');
    }

    function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    function Ask_price_lits(){
        return $this->hasMany('App\AskPriceLits', 'ask_price_id');
    }
    
    function askPriceSuppliers(){
        return $this->hasMany('App\AskPriceSupplier', 'ask_price_id');
    }
}
