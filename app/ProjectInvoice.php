<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectInvoice extends Model
{

    protected $fillable = ['project_id','branch_id', 'date', 'code', 'note', 'payment_condition', 'credit_amount', 'credit_note', 'credit_date', 'status', 'user_id','discount','vat_type','tax_base','vat_amount','total'];
    
    function project(){
        return $this->belongsTo(\App\Project::class, 'project_id');
    }
    
    function branch(){
        return $this->belongsTo(\App\Branch::class, 'branch_id');
    }

    function user(){
        return $this->belongsTo(\App\User::class, 'user_id');
    }
    
    function incomes(){
        return $this->hasMany(\App\Income::class, 'invoice_id');
    }
    
    
    function ar_lists(){
        return $this->hasMany(\App\ReceiptArList::class, 'project_invoice_id');
    }
}
