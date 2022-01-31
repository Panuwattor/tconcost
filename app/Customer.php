<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'tel', 'fax', 'address', 'note', 'status', 'txt_tin', 'email' , 'branch_id'];

    function contracts(){
        return $this->hasMany(\App\SupplierContract::class, 'customer_id');
    }
        
    function branch(){
        return $this->belongsTo(\App\Branch::class, 'branch_id');
    }
}
