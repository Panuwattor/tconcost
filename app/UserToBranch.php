<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserToBranch extends Model
{
    protected $fillable = [
        'user_id', 'branch_id', 'status'
    ];

    function branch(){
        return $this->belongsTo(\App\Branch::class, 'branch_id');
    }

    function user(){
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
