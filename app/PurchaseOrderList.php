<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderList extends Model
{
    protected $fillable = ['purchase_order_id', 'name', 'amount', 'unit', 'unit_price', 'unit_discount', 'price',
                            'received', 'special_discount', 'receive_special_discount', 'vat'
                        ];

    function po(){
        return $this->belongsTo(\App\PurchaseOrder::class, 'purchase_order_id');
    }

    function allocate(){
        return $this->hasOne(\App\Allocate::class, 'po_list_id');
    }

    function accounting(){
        return $this->belongsTo(\App\Account::class, 'accounting_id');
    }

    function getTotalDiscountAttribute(){
        return ($this->amount * $this->unit_discount) * $this->special_discount ;
    }

    function receives_list(){
        return $this->hasMany(\App\ReceiveList::class, 'po_list_id');
    }

    function listNotes(){
        return $this->hasMany(\App\PoListNote::class, 'po_list_id');
    }        

}
