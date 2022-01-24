<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = ['name','project_id','customer_id','project_type_id','code',
                            'year','general','type','project_cost','vat','address','vat_type','start_date',
                            'finish_date','note','user_id','main_user_id','status','branch_id'
                        ];

    function lists()
    {
        return $this->hasMany(\App\QuotationList::class, 'quotation_id');
    }

    function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    function main_user()
    {
        return $this->belongsTo('App\User', 'main_user_id');
    }

    function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    function branch()
    {
        return $this->belongsTo('App\Branch', 'branch_id');
    }
    function project_type()
    {
        return $this->belongsTo('App\ProjectType', 'project_type_id');
    }
    function getStateAttribute()
    {
        if ($this->status == 0) {
            return '<small class="badge badge-danger">ยกเลิก</small>';
        } else if ($this->status == 1) {
            return '<small class="badge badge-info">สร้าง</small>';
        }
        else if ($this->status == 3) {
            return '<small class="badge badge-info">อนุมัติ</small>';
        }
        else if ($this->status == 4) {
            return '<small class="badge badge-success">เป็นโครงการแล้ว</small>';
        }
    }
}
