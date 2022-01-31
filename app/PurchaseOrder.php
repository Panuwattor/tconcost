<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PurchaseOrder extends Model
{
    protected $fillable = ['code','project_id','branch_id', 'supplier_id', 'po_date', 'due_date', 'address', 'tel', 'main_user_id', 'payment_type', 'cradit', 'total_price', 'special_discount', 'sum_price', 'vat_type', 'vat_amount', 'patment_condition', 'note', 'status', 'user_id', 'approve_user_id', 'reject_note', 'po_type', 'contract_id', 'approve_user_time', 'main_approve_user_id', 'main_approve_user_time','bank_account_id', 'receive_special_discount','notify'];

    
    function approve_user()
    {
        return $this->belongsTo('App\User', 'approve_user_id');
    }

    function main_approve_user()
    {
        return $this->belongsTo('App\User', 'main_approve_user_id');
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

    function purchaseOrderLists()
    {
        return $this->hasMany(\App\PurchaseOrderList::class, 'purchase_order_id');
    }

    function poFiles()
    {
        return $this->hasMany('App\PoFile', 'purchase_order_id');
    }

    function getpostatusAttribute()
    {
        if ($this->status == 0) {
            return '<small class="badge badge-warning">รออนุมัติ</small>';
        } else if ($this->status == 1) {
            return '<small class="badge badge-info">รอรับของ</small>';
        } else if ($this->status == 2) {
            return '<small class="badge badge-danger">ยกเลิก</small>';
        } else if ($this->status == 4) {
            return '<small class="badge badge-danger">ยกเลิก</small>';
        } else if ($this->status == 3) {
            return '<small class="badge badge-success">รับของเรียบร้อย</small>';
        } else if ($this->status == 5) {
            return '<small class="badge badge-success">รับของเรียบร้อย</small>';
        } else if ($this->status == 6) {
            return '<small class="badge badge-success">เสร็จสิ้น</small>';
        }
    }

    function supplier()
    {
        return $this->belongsTo('App\Customer', 'supplier_id');
    }

    function contract()
    {
        return $this->belongsTo(\App\SupplierContract::class, 'contract_id');
    }

    function poHasprs()
    {
        return $this->hasMany(\App\PoHasPr::class, 'po_id');
    }

    function receives()
    {
        return $this->hasMany(\App\Receive::class, 'po_id');
    }

    function deposits()
    {
        return $this->hasMany(\App\DepositPay::class, 'po_id');
    }

    function accounting()
    {
        return $this->belongsTo(\App\Account::class, 'contract_id');
    }

    function bank_account()
    {
        return $this->belongsTo(\App\BankAccount::class, 'bank_account_id');
    }

    function deposit_pays()
    {
        return $this->hasMany(\App\DepositPay::class, 'po_id');
    }

    function new_po()
    {
        return $this->hasOne(\App\PoToNewPo::class, 'purchase_order_id');
    }

    function logs()
    {
        return $this->hasMany(\App\ProjectLog::class, 'type_id')->where('type', 'PO');
    }

    public function getReceiveRemainAttribute()
    {
        return ($this->vat_amount + $this->sum_price) - $this->receives->whereIn('status', [0, 1, 2])->sum('sum');
    }

    function other_receives()
    {
        return $this->hasMany(\App\OtherReceive::class, 'po_id');
    }

    function other_payment_lists()
    {
        return $this->hasMany(\App\OtherPaymentList::class, 'po_id');
    }

    public function getInvoicesApAttribute()
    {
        $invoice_ap_lists = DB::table('purchase_orders')
            ->select('invoice_ap_lists.*')
            ->join('receives', 'receives.po_id', '=', 'purchase_orders.id')
            ->join('invoice_ap_lists', 'invoice_ap_lists.receive_id', '=', 'receives.id')
            ->where('purchase_orders.id', $this->id)
            ->get();

        $invoices = [];

        foreach($invoice_ap_lists as $_invoice_ap_list){
            $_invoice = InvoiceAp::find($_invoice_ap_list->invoice_ap_id);

            if($_invoice->status == 0 || $_invoice->status == 1 || $_invoice->status == 2){
                array_push($invoices, $_invoice);
            }
        }

        return $invoices;
    }

    public function getMainPaymentAttribute()
    {
        $invoice_ap_lists = DB::table('purchase_orders')
            ->select('invoice_ap_lists.*')
            ->join('receives', 'receives.po_id', '=', 'purchase_orders.id')
            ->join('invoice_ap_lists', 'invoice_ap_lists.receive_id', '=', 'receives.id')
            ->join('main_payment_lists', 'main_payment_lists.invoice_id', '=', 'receives.id')
            ->where('purchase_orders.id', $this->id)
            ->get();

        $main_payments = [];

        foreach($invoice_ap_lists as $_invoice_ap_list){
            $_invoice = InvoiceAp::find($_invoice_ap_list->invoice_ap_id);

            if($_invoice->main_payments_list->count() > 0){
                foreach($_invoice->main_payments_list as $main_payment_list){
                    $main_payment = MainPayment::whereIn('status', [0, 1])->where('id', $main_payment_list->main_payment_id)->first();
                    if($main_payment){
                        array_push($main_payments, $main_payment);
                    }
                }
            }
        }

        return $main_payments;
    }
}
