<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wht extends Model
{
    protected $fillable = ['payment_id','payment_type','project_id','supplier_id','code','date','type','wht_payment_type','note',
                            'name','tax_id','address','attribute','attribute_count','user_id', 'status','branch_id'];

    function payment(){
        if($this->payment_type == 'MainPayment'){
            return $this->belongsTo(\App\MainPayment::class, 'payment_id');
        }else{
            return $this->belongsTo(\App\OtherPayment::class, 'payment_id');
        }
    }
    
    function getPayTypeAttribute()
    {
        if($this->payment_type == 'MainPayment'){
            return 'MainPayment';
        }else{
            return 'OtherPayment';
        }
    }

    function supplier(){
        return $this->belongsTo(\App\Customer::class, 'supplier_id');
    }

    function branch(){
        return $this->belongsTo(\App\Branch::class, 'branch_id');
    }
    
    function wht_lists(){
        return $this->hasMany(\App\WhtList::class, 'wht_id');
    }

    function getstateAttribute(){
        if($this->status == 0){
            return '<small class="badge badge-info">สร้าง</small>';
        }else if($this->status == 1){
            return '<small class="badge badge-warning">อนุมัติ</small>';
        }else if($this->status == 2){
            return '<small class="badge badge-success">เสร็จ</small>';
        }else if($this->status == 3){
            return '<small class="badge badge-danger">ยกเลิก</small>';
        }else if($this->status == 4){
            return '<small class="badge badge-success">ชำระเงินเรียบร้อย</small>';
        }else if($this->status == 10){
            return '<small class="badge badge-danger">ลบ</small>';
        }
    }

    public function taxID($tax)
    {
        $array  = array_map('intval', str_split((int)$tax));
        return collect($array);
    }

    function other_payments_list(){
        return $this->hasMany(\App\OtherPaymentList::class, 'wht_id');
    }

    function getOtherPaymentAttribute(){
        $other_payments_list = $this->other_payments_list;;
        $state = true;
        foreach($other_payments_list as $other_payment_list){
            if($other_payment_list->other_payment->status == 1){
                $state = false;
                return $other_payment_list->other_payment;
            }
        }

        if($state){
            return null;
        }
    }

    function project(){
        return $this->belongsTo(\App\Project::class, 'project_id');
    }
}
