<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AskPriceSupplier extends Model
{
    protected $fillable = ['ask_price_id', 'customer_id'];
    
    function purchase_request(){
        return $this->belongsTo('App\AskPrice', 'ask_price_id');
    }

    function customer(){
        return $this->belongsTo('App\Customer', 'customer_id');
    }
}
