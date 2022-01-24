<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allocate extends Model
{
    protected $fillable = ['po_list_id', 'payment_id', 'main_payment_id', 'other_receive_list_id'];

    function allocate_list(){
        return $this->hasMany(\App\AllocateList::class, 'allocate_id');
    }

    function po_list(){
        return $this->belongsTo(\App\PurchaseOrderList::class, 'po_list_id');
    }
    
    function other_payment(){
        return $this->belongsTo(\App\OtherPayment::class, 'payment_id');
    }
    
    function main_payment(){
        return $this->belongsTo(\App\MainPayment::class, 'main_payment_id');
    }
    
    function other_receive_list(){
        return $this->belongsTo(\App\OtherReceiveList::class, 'other_receive_list_id');
    }
}
