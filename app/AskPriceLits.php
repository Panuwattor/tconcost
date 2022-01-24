<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AskPriceLits extends Model
{
    protected $fillable = ['ask_price_id','name','amount','unit'];

    function purchase_request(){
        return $this->belongsTo('App\AskPrice', 'ask_price_id');
    }
}
