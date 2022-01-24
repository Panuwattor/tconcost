<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoFile extends Model
{
    protected $fillable = ['purchase_order_id', 'file'];

    function po(){
        return $this->belongsTo('App\PurchaseOrder', 'purchase_order_id');
    }
}
