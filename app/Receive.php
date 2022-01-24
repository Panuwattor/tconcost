<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    //ใช้สำหรับประเภท RS other_receive_status 1 คือสร้าง other receive เเล้ว ถ้า 0 ยังไม่ได้สร้าง

    protected $fillable = ['project_id', 'po_id', 'supplier_id', 'user_id', 'date', 'type', 'po_remain', 'po_remain_percent', 'note', 'status', 'receive_code', 'duedate_id', 'payment_condition', 'sum_price', 'vat_amount', 'sum', 'user_approve_id', 'reject_note', 'approveDate', 'special_discount', 'other_receive_status'];
    protected $dates = ['approveDate'];

    function receive_lists()
    {
        return $this->hasMany(\App\ReceiveList::class, 'receive_id');
    }

    function receive_files()
    {
        return $this->hasMany(\App\ReceiveFile::class, 'receive_id');
    }

    function project()
    {
        return $this->belongsTo(\App\Project::class, 'project_id');
    }

    function po()
    {
        return $this->belongsTo(\App\PurchaseOrder::class, 'po_id');
    }

    function supplier()
    {
        return $this->belongsTo(\App\Customer::class, 'supplier_id');
    }

    function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    function user_approve()
    {
        return $this->belongsTo(\App\User::class, 'user_approve_id');
    }

    function duedate()
    {
        return $this->belongsTo(\App\ReceiveDueDate::class, 'duedate_id');
    }

    function retention()
    {
        return $this->hasOne(\App\Retention::class, 'receive_id');
    }

    function getreceivestatusAttribute()
    {
        if ($this->status == 0) {
            return '<small class="badge badge-info">สร้าง</small>';
        } else if ($this->status == 1) {
            return '<small class="badge badge-success">เสร็จสิ้น</small>';
        } else if ($this->status == 2) {
            return '<small class="badge badge-success">อนุมัติ</small>';
        } else if ($this->status == 3) {
            return '<small class="badge badge-danger">ไม่อนุมัติ</small>';
        } else if ($this->status == 10) {
            return '<small class="badge badge-danger">ยก เลิกโดยการแก้ไข</small>';
        } else if ($this->status == 15) {
            return '<small class="badge badge-danger">ยกเลิก การรับของ</small>';
        }
    }

    function invoice_ap_lists()
    {
        return $this->hasMany(\App\InvoiceApList::class, 'receive_id');
    }

    function other_receives()
    {
        return $this->hasMany(\App\OtherReceive::class, 'receive_id');
    }
}
