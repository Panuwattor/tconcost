<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiveList extends Model
{
    protected $fillable = ['receive_id','name','amount','unit','unit_price','unit_discount','price','vat', 'po_list_id', 'accounting_id', 'special_discount','fromAmount', 'other_receive_list_id', 'invoice_discount'];

    function receive(){
        return $this->belongsTo(\App\Receive::class, 'receive_id');
    }

    function accounting(){
        return $this->belongsTo(\App\Account::class, 'accounting_id');
    }

    function po_list(){
        return $this->belongsTo(\App\PurchaseOrderList::class, 'po_list_id');
    }

    function getPoListAmountAttribute(){
        return $this->po_list->amount;
    }

    function getPoListPriceAttribute(){
        return $this->po_list->price;
    }

    function getTotalWithdrawalAttribute(){
        return $this->fromAmount * $this->po_list->price;
    }

    function getPoListBalanceAttribute(){
        return ($this->poListAmount - ($this->fromAmount + $this->amount) ) * $this->po_list->unit_price;
    }
    
}
