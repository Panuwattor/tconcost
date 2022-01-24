<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retention extends Model
{
    protected $fillable = ['receive_id','project_id','price','user_id','staus'];
}
