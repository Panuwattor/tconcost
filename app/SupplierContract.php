<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierContract extends Model
{
    protected $fillable = ['customer_id', 'name', 'tel', 'fax', 'address', 'note', 'email', 'txt_tin','status'];
}
