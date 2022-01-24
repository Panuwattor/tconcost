<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'tel', 'fax', 'address', 'note', 'status', 'txt_tin', 'email'];

    function contracts(){
        return $this->hasMany(\App\SupplierContract::class, 'customer_id');
    }
}
