<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retention extends Model
{
    protected $fillable = ['receive_id','project_id','branch_id','customer_id','price','user_id','staus'];

    function receive(){
        return $this->belongsTo(\App\Receive::class, 'receive_id');
    }

    function project(){
        return $this->belongsTo(\App\Project::class, 'project_id');
    }

    function branch(){
        return $this->belongsTo(\App\Branch::class, 'branch_id');
    }
    
    function customer(){
        return $this->belongsTo(\App\Customer::class, 'customer_id');
    }
    
    function user(){
        return $this->belongsTo(\App\User::class, 'user_id');
    }
    function getTextStausAttribute()
    {
        if ($this->status == 0) {
            return '<small class="badge badge-info">รอจ่าย</small>';
        } else if ($this->status == 1) {
            return '<small class="badge badge-success">จ่ายแล้ว</small>';
        } else if ($this->status == 3) {
            return '<small class="badge badge-danger">ยกเลิก</small>';
        }
    }
    
}
