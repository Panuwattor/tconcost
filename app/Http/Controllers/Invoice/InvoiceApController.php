<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Account;
use App\AccountView;
use App\Customer;
use App\DepositMethod;
use App\DepositPay;
use App\InvoiceAp;
use App\InvoiceApList;
use App\MainRetention;
use App\OtherReceive;
use App\OtherReceiveList;
use App\Project;
use App\Receive;
use App\ReceiveList;
use App\Retention;
use Carbon\Carbon;
use DB;

class InvoiceApController extends Controller
{
    public function index()
    {
        $projects = Project::where('status', '!=', 0)->whereIn('type', [0, 1])->get();
        $suppliers = Customer::whereIn('status', ['supplier','customer , supplier'])->where('cancle_state', 0)->get();
        $invoices = InvoiceAp::where('status', 0)->get();

        return view('invoice-ap.index', compact('projects', 'suppliers', 'invoices'));
    }
    
    public function all_approve()
    {
        $invoices = InvoiceAp::where('status', 2)->get();

        return view('invoice-ap.approve', compact('invoices'));
    }
   
    public function all_reject()
    {
        $invoices = InvoiceAp::where('status', 3)->get();

        return view('invoice-ap.reject', compact('invoices'));
    }
    
    public function finish()
    {
        $projects = Project::where('status', '!=', 0)->whereIn('type', [0, 1])->get();
        $suppliers = Customer::whereIn('status', ['supplier','customer , supplier'])->where('cancle_state', 0)->get();
        $invoices = InvoiceAp::where('status', 1)->get();

        return view('invoice-ap.finish', compact('projects', 'suppliers', 'invoices'));
    }

    public function getReceive()
    {
        $recives = [];

        if (request('search_code')) {
            $recives = Receive::where('status', 2)->where('supplier_id', request('supplier_id'))->where('project_id', request('project_id'))->where('receive_code', 'like', '%' . request('search_code') . '%')->get();
            foreach ($recives as $i => $recive) {
                $recives[$i]['vat_type'] = $recive->po->vat_type;
            }
        }

        return response()->json($recives);
    }

    public function create()
    {
        $project = Project::find(request('project_id'));
        $supplier = Customer::find(request('supplier_id'));
        $all_accounts = Account::all();

        $receives = [];
        $vat_type = '';

        if(!request('res_receive')){
            alert()->error('ผิดพลาด', 'เลือกรายการก่อน');
            return back();
        }
        foreach (request('res_receive') as $recive_id) {
            $r = Receive::find($recive_id);
            $r['receive_lists'] = $r->receive_lists;
            $vat_type = $r->po->vat_type;
            array_push($receives, $r);
        }

        $json_receives = json_encode($receives);

        // dd($receives[0]->receive_lists);
        return view('invoice-ap.create', compact('project', 'supplier', 'receives', 'all_accounts', 'vat_type', 'json_receives'));
    }

    public function store()
    {
        if(sizeof(array_unique(request('receive_account_id'))) > 1){
            alert()->error('ผิดพลาด', 'เลือกผังบัญชี คนละประเภท');
            return redirect('/invoice-ap');
        }
        
        if(request('deposit_use') && array_sum(request('deposit_use')) > 0 &&  request('sum') != 0){
            alert()->error('ผิดพลาด', 'ยอดไม่เท่ากัน');
            return redirect('/invoice-ap');
        }

        DB::transaction(function () {
            $_po_id = '';
            $project = Project::find(request('project_id'));
            $count = InvoiceAp::whereBetween('date', [Carbon::createFromFormat('Y-m-d',request('date'))->format('Y-m-01') . ' 00:00:00', Carbon::createFromFormat('Y-m-d',request('date'))->format('Y-m-t') . ' 23:59:59'])->where('project_id',$project->id)->count();
            $code = 'AP' . $project->code . Carbon::createFromFormat('Y-m-d',request('date'))->format('ym') . sprintf("%'04d", $count + 1);
            $reques = request()->all();
            $reques['user_id'] = auth()->user()->id;
            $reques['code'] = $code;

            $invoice_ap = InvoiceAp::create($reques);

            foreach (request('receives_id') as $receive_id) {
                $receive = Receive::find($receive_id);
                $receive->status = 1;
                $receive->update();

                $_po_id = $receive->po_id;

                InvoiceApList::create([
                    'invoice_ap_id' => $invoice_ap->id, 
                    'receive_id' => $receive_id,
                ]);

                $receive->po->project->logs()->create([
                    'type'=>'PO',
                    'type_id'=>$receive->po->id,
                    'user_id'=>auth()->user()->id,
                    'note'=> 'สร้าง : ' .$code
                ]);

                if($receive->type == 'RS' && request('sum') > 0){
                    $count = OtherReceive::where('type', 'JV')->whereBetween('created_at', [Carbon::today()->format('Y-m-01') . ' 00:00:00', Carbon::today()->format('Y-m-t') . ' 23:59:59'])->count();
                    $code = 'JV' . Carbon::today()->format('Ym') . sprintf("%'03d", $count + 1);
                    
                    $other_receive = OtherReceive::create([
                        'ap_id' => $invoice_ap->id,
                        'supplier_id' => $invoice_ap->supplier_id,
                        'project_id' => $invoice_ap->project_id,
                        'user_id' => auth()->user()->id,
                        'date' => Carbon::today()->format('Y-m-d'),
                        'type' => 'JV',
                        'code' => $code,
                        'amount' => $invoice_ap->tax_base + $invoice_ap->vat,
                        'tax_base' => $invoice_ap->tax_base + $invoice_ap->vat,
                        'vat' => 0,
                        'vat_type' => $receive->po->vat_type,
                        'payment_type' => $receive->po->payment_type,
                        'cradit' => $receive->po->cradit,
                    ]);
        
                    // ค่าวัสดุก่อสร้าง
                    $ConstructionCost = Account::where('code', 510001)->first();
                    OtherReceiveList::create([
                        'other_receive_id' => $other_receive->id,
                        'accounting_id' => $ConstructionCost->id,
                        'vat' => 0,
                        'price' => $invoice_ap->tax_base + $invoice_ap->vat,
                        'amount' => $invoice_ap->tax_base + $invoice_ap->vat,
                        'type' => 'receive',
                    ]);

                    // other_receive_id
                    $ap = Account::where('code', 210101)->first();
                    OtherReceiveList::create([
                        'other_receive_id' => $other_receive->id,
                        'accounting_id' => $ap->id,
                        'vat' => 0,
                        'price' => $invoice_ap->tax_base + $invoice_ap->vat,
                        'amount' => $invoice_ap->tax_base + $invoice_ap->vat,
                        'type' => 'subtract'
                    ]);
        
                    AccountView::create([
                        'other_receive_id' => $other_receive->id,
                        'type' => 'other_receive',
                        'account_id' => $ap->id,
                        'project_id' =>  $invoice_ap->project_id,
                        'debit' => $invoice_ap->tax_base + $invoice_ap->vat,
                        'user_id' => auth()->user()->id,
                    ]);
        
                    AccountView::create([
                        'other_receive_id' => $other_receive->id,
                        'type' => 'other_receive',
                        'account_id' => $ConstructionCost->id,
                        'project_id' =>  $invoice_ap->project_id,
                        'credit' => $invoice_ap->tax_base + $invoice_ap->vat,
                        'user_id' => auth()->user()->id,
                    ]); 
                }
            }

            foreach(request('receives_list_id') as $r => $receive_list_id){
                $receive_list = ReceiveList::find($receive_list_id);
                $receive_list->accounting_id = request('receive_account_id')[$r];
                $receive_list->invoice_discount = request('receive_list_invoice_discount')[$r];
                $receive_list->update();
            }

            AccountView::create([
                'ap_id' => $invoice_ap->id,
                'type' => 'AP',
                'account_id' => request('receive_account_id')[0],
                'project_id' => $invoice_ap->project_id,
                'debit' => request('tax_base'),
                'user_id' => auth()->user()->id,
            ]);

            if(request('retention_id')){
                $retention = Retention::find(request('retention_id'));
                $retention->price = request('retention');
                $retention->update();
            }

            $acc = Account::where('code', 110401)->first();
            $acc1 = Account::where('code', 110402)->first();
            if (request('tax_invoice_no')) {
                if (request('vat') > 0) {
                    AccountView::create([
                        'ap_id' => $invoice_ap->id,
                        'type' => 'AP',
                        'account_id' => $acc->id,
                        'project_id' => $invoice_ap->project_id,
                        'debit' => request('vat'),
                        'user_id' => auth()->user()->id,
                    ]);
                }
            } else {
                if (request('vat') > 0) {
                    AccountView::create([
                        'ap_id' => $invoice_ap->id,
                        'type' => 'AP',
                        'account_id' => $acc1->id,
                        'project_id' => $invoice_ap->project_id,
                        'debit' => request('vat'),
                        'user_id' => auth()->user()->id,
                    ]);
                }
            }

            if(request('deposit_id')){
                foreach (request('deposit_id') as $p => $deposit_id) {
                    $deposit = DepositPay::find($deposit_id);
    
                    DepositMethod::create([
                        'ap_id' => $invoice_ap->id,
                        'deposit_id' => $deposit->id,
                        'amount' => request('deposit_use')[$p],
                    ]);

                    $de = Account::where('code', 110406)->first();
                    AccountView::create([
                        'ap_id' => $invoice_ap->id,
                        'type' => 'AP',
                        'account_id' => $de->id,
                        'project_id' => $invoice_ap->project_id,
                        'credit' => request('deposit_use')[$p],
                        'user_id' => auth()->user()->id,
                    ]);
                }
            }

            if(request('sum') <= 0){
                if (request('retention') > 0) {
                    $project = Project::find(request('project_id'));
    
                    $count = MainRetention::whereBetween('created_at', [Carbon::today()->format('Y-m-01') . ' 00:00:00', Carbon::today()->format('Y-m-t') . ' 23:59:59'])->count();
                    $code = 'PV' . Carbon::today()->format('Ym') . sprintf("%'03d", $count + 1);
    
                    MainRetention::create([
                        'project_id' => request('project_id'),
                        'po_id' => $_po_id,
                        'invoice_id' => $invoice_ap->id,
                        'date' => Carbon::today()->format('Y-m-d'),
                        'supplier_id' => request('supplier_id'),
                        'receive_id' => request('receives_id')[0],
                        'code' => $code,
                        'balance' => request('retention'),
                        'user_id' => auth()->user()->id,
                        // 'vat_type' => request('vat_type'),
                    ]);
                }
            }

            $_retention = 0;
            if (request('retention') > 0){
                $re = Account::where('code', 210103)->first();
                $_retention = request('retention');
                // AccountView::create([
                //     'ap_id' => $invoice_ap->id,
                //     'type' => 'AP',
                //     'account_id' => $re->id,
                //     'project_id' => $invoice_ap->project_id,
                //     'credit' => request('retention'),
                //     'user_id' => auth()->user()->id,
                // ]);
            }

            if(request('sum') > 0){
                $a = Account::where('code', 210101)->first();
                AccountView::create([
                    'ap_id' => $invoice_ap->id,
                    'type' => 'AP',
                    'account_id' => $a->id,
                    'project_id' => $invoice_ap->project_id,
                    'credit' => request('sum') + $_retention,
                    'user_id' => auth()->user()->id,
                ]);
            }
            
        });

        return redirect('/invoice-ap');
    }

    public function show(InvoiceAp $invoice)
    {
        
        return view('invoice-ap.show', compact('invoice'));
    }

    public function print(InvoiceAp $invoice)
    {
        
        return view('invoice-ap.print', compact('invoice'));
    }

    public function approve()
    {
        $invoice = InvoiceAp::find(request('invoice_id'));
        if ($invoice->status != 0) {
            alert()->error('ผิดพลาด', 'ไม่ใช่สถานะ รออนุมัติ');
            return redirect('/invoice-ap');
        }

        DB::transaction(function(){
            $invoice = InvoiceAp::find(request('invoice_id'));
            $invoice->user_approve_id = auth()->user()->id;
            $invoice->user_approve_time = Carbon::now();
            $invoice->status = 2;
            $invoice->update();

            foreach ($invoice->account_views as $account_view) {
                $account_view->status = 1;
                $account_view->update();
            }

            foreach($invoice->deposit_methods as $deposit_method){
                $deposit_method->status = 1;
                $deposit_method->update();

                $deposit_method->deposit->remian = $deposit_method->deposit->remian - $deposit_method->amount;
                $deposit_method->deposit->update();
            }

            if($invoice->main_retention){
                $invoice->main_retention->status = 2;
                $invoice->main_retention->update();
            }

            if ($invoice->other_receives->count() > 0) {
                foreach ($invoice->other_receives as $_other_receive) {

                    $_other_receive->status = 2;
                    $_other_receive->update();

                    foreach ($_other_receive->other_receive_lists as $list) {
                        $list->status = 2;
                        $list->update();
                    }
                }
            }
        });

        alert()->success('สำเร็จ', 'อนุมัติเรียบร้อย');
        return redirect('/invoice-ap');
    }
    
    public function reject_store()
    {
        $invoice = InvoiceAp::find(request('invoice_id'));
        if ($invoice->status == 1 || $invoice->status == 3) {
            alert()->error('ผิดพลาด', 'ไม่ใช่สถานะ รออนุมัติ');
            return redirect('/invoice-ap');
        }

        if($invoice->status == 2){
            if($invoice->main_payments_list->count() > 0){
                foreach($invoice->main_payments_list as $_main_payments_list){
                    if($_main_payments_list->main_payment->status == 0 || $_main_payments_list->main_payment->status == 1){
                        alert()->error('ผิดพลาด', 'ไม่สามารถ Reject ได้');
                        return redirect('/invoice-ap');
                    }
                }
            }
        }

        DB::transaction(function(){
            $invoice = InvoiceAp::find(request('invoice_id'));
            $invoice->user_approve_id = auth()->user()->id;
            $invoice->user_approve_time = Carbon::now();
            $invoice->reject_note = request('reject_note');
            $invoice->status = 3;
            $invoice->update();

            foreach ($invoice->invoice_lists as $invoice_list) {
                $invoice_list->receive->status = 2;
                $invoice_list->receive->update();

                foreach($invoice_list->receive->receive_lists as $receive_list){
                    $receive_list->invoice_discount = 0;
                    $receive_list->update();
                }
            }
            
            foreach ($invoice->account_views as $account_view) {
                $account_view->status = 2;
                $account_view->update();
            }

            foreach($invoice->deposit_methods as $deposit_method){
                if($invoice->status == 1 || $invoice->status == 2){
                    $deposit_method->deposit->remian = $deposit_method->deposit->remian + $deposit_method->amount;
                    $deposit_method->deposit->update();
                }

                $deposit_method->status = 2;
                $deposit_method->update();
            }

            if($invoice->main_retention){
                $invoice->main_retention->status = 3;
                $invoice->main_retention->update();
            }

            if ($invoice->other_receives->count() > 0) {
                foreach ($invoice->other_receives as $_other_receive) {

                    $_other_receive->status = 3;
                    $_other_receive->update();

                    foreach ($_other_receive->other_receive_lists as $list) {
                        $list->status = 3;
                        $list->update();
                    }
                }
            }
        });

        alert()->success('สำเร็จ', 'Approve เรียบร้อย');
        return redirect('/invoice-ap');
    }

    public function report()
    {
        $from = request('from') ? request('from') : Carbon::today()->format('Y-m-d');
        $to = request('to') ? request('to') : Carbon::today()->format('Y-m-d');
        $date_type = request('date_type') ? request('date_type') : 'date';
        $project_id = request('project_id') ? request('project_id') : 'all';
        $projects = Project::all();
        
        if(request('date_type') == 'date'){
            if(request('project_id') == 'all'){
                $data = InvoiceAp::whereBetween('date', [$from , $to])->get();
            }else{
                $data = InvoiceAp::where('project_id', $project_id)->whereBetween('date', [$from , $to])->get();
            }
        }else{
            if(request('project_id') == 'all'){
                $data = InvoiceAp::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
            }else{
                $data = InvoiceAp::where('project_id', $project_id)->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
            }
        }

        return view('invoice-ap.report', compact('from','to','date_type','projects','data','project_id'));
    }
}
