<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptAr extends Model
{
    protected $fillable = ['project_id', 'code', 'tax', 'date', 'note', 'amount', 'remain', 'receipt_amount', 'user_id', 'status' ,'branch_id'];

    function project()
    {
        return $this->belongsTo(\App\Project::class, 'project_id');
    }
    
    function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
    function user_approve()
    {
        return $this->belongsTo(\App\User::class, 'user_approve_id');
    }

    function receipt_ar_list(){
        return $this->hasMany(\App\ReceiptArList::class, 'receipt_ar_id');
    }

    function branch(){
        return $this->belongsTo(\App\Branch::class, 'branch_id');
    }

}
