<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WhtGroup extends Model
{
    protected $fillable = ['name', 'percent', 'note', 'status'];
}
