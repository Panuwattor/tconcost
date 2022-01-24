<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'address', 'tel', 'tax', 'note','company','company_eng','logo','code','tax_code','status'];
}
