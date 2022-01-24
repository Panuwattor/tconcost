<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [ 'name','customer_id','project_type_id','code','year','general','project_cost','vat','address','vat_type','start_date','finish_date','note','user_id','main_user_id','status','branch_id','type'];

    function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    function main_user()
    {
        return $this->belongsTo('App\User', 'main_user_id');
    }

    function project_type()
    {
        return $this->belongsTo('App\ProjectType', 'project_type_id');
    }
    
    function branch()
    {
        return $this->belongsTo('App\Branch', 'branch_id');
    }

    function logs(){
        return $this->hasMany(\App\ProjectLog::class, 'project_id');
    }

    function cost_plans(){
        return $this->hasMany(\App\ProjectCostPlan::class, 'project_id');
    }
    
    function getStateAttribute()
    {
        if ($this->status == 0) {
            return '<small class="badge badge-warning">สร้าง</small>';
        } else if ($this->status == 1) {
            return '<small class="badge badge-info">สมบูรณ์</small>';
        }
        else if ($this->status == 2) {
            return '<small class="badge badge-info">ฉะลอ</small>';
        }
        else if ($this->status == 3) {
            return '<small class="badge badge-success">เสร็จสิ้นโครงการ</small>';
        }
        else if ($this->status == 4) {
            return '<small class="badge badge-success">สิ้นสุด</small>';
        }
        else if ($this->status == 99) {
            return '<small class="badge badge-info">ยกเลิก</small>';
        }
    }

    function incomes(){
        return $this->hasMany(\App\Income::class, 'project_id');
    }

    function invoices(){
        return $this->hasMany(\App\ProjectInvoice::class, 'project_id');
    }

    function receiptArs()
    {
        return $this->hasMany(\App\ReceiptAr::class, 'project_id');
    }

    function quotation(){
        return $this->hasOne(\App\Quotation::class, 'project_id');
    }

}
