<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptArList extends Model
{
    protected $fillable = ['receipt_ar_id', 'project_invoice_id', 'income_id', 'receipt'];
    
    function receipt_ar(){
        return $this->belongsTo(\App\ReceiptAr::class, 'receipt_ar_id');
    }
    
    function project_invoice(){
        return $this->belongsTo(\App\ProjectInvoice::class, 'project_invoice_id');
    }
    
    function income(){
        return $this->belongsTo(\App\Income::class, 'income_id');
    }

}
