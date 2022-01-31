<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Income;
use App\ProjectInvoice;
use App\Project;
use App\ReceiptAr;
use App\Branch;
use App\ReceiptArList;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceReceiptController extends Controller
{
    public function create()
    {
        $invoice_ars = array();
        $project = '';
        $project_id = array();

        if (!request('invoices')) {
            alert()->error('ผิดพลาด', 'ไม้ได้เลือก');
            return back();
        }

        foreach (request('invoices') as $invoice_id) {
            $iar = ProjectInvoice::find($invoice_id);
            array_push($project_id, $iar->project_id);
        }

        if (sizeof(array_unique($project_id)) > 1) {
            alert()->error('ผิดพลาด', 'มี invoice ar มากกว่า 1 โครงการ');
            return back();
        }

        foreach (request('invoices') as $invoice_id) {
            $invoice_ar = ProjectInvoice::find($invoice_id);
            $project = $invoice_ar->project;
            if($invoice_ar->status == 99){
                alert()->error('ผิดพลาด', 'มี invoice ar ยกเลิกไปแล้ว');
                return redirect('/project/add-income/new/'.$project->id);
            }
            array_push($invoice_ars, $invoice_ar);
        }

        if($project->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }

        return view('project.receipt.create', compact('invoice_ars', 'project'));
    }

    public function store()
    {
        $sate = false;
        foreach (request('invoice_ar') as $check_invoice_ar_id) {
            $check_invoice_ar = ProjectInvoice::find($check_invoice_ar_id);

            if ($check_invoice_ar->status != 0) {
                $sate = true;
            }
        }

        if ($sate) {
            alert()->error('ผิดพลาด', 'มีรายการที่ถูกใช้ไปแล้ว');
            return redirect('/invoice-ar');
        }

       $receipt_ar = DB::transaction(function () {
            $project = Project::find(request('project_id'));
            $branch = $project->branch;
            if ($project->vat_type == 'ไม่มี') {
                $count = ReceiptAr::whereBetween('date', [Carbon::createFromFormat('Y-m-d', request('date'))->format('Y-m-01') . ' 00:00:00', Carbon::createFromFormat('Y-m-d', request('date'))->format('Y-m-t') . ' 23:59:59'])->where('tax',0)->where('branch_id', $branch->id)->count();
                $code = 'REC-' . Carbon::createFromFormat('Y-m-d', request('date'))->format('Ym') . sprintf("%'03d", $count + 1);
                $head = 'REC-';
                $tax = 0;
            } else {
                $count = ReceiptAr::whereBetween('date', [Carbon::createFromFormat('Y-m-d', request('date'))->format('Y-m-01') . ' 00:00:00', Carbon::createFromFormat('Y-m-d', request('date'))->format('Y-m-t') . ' 23:59:59'])->where('tax', 1)->where('branch_id', $branch->id)->count();
                $code = 'BI-' .  Carbon::createFromFormat('Y-m-d', request('date'))->format('Ym') . sprintf("%'03d", $count + 1);
                $head = 'BI-';
                $tax = 1;
            }

            $test_code = ReceiptAr::where('code',$code)->where('branch_id', $branch->id)->exists();
            if($test_code){
                $code = $code.'1';
            }

            $receipt_ar = ReceiptAr::create([
                'project_id'=>$project->id,
                 'code' => $code,
                 'tax' => $tax,
                 'date' => request('date'),
                 'note' => request('note'),
                 'amount' => request('amount'),
                 'remain' => request('remain'),
                 'receipt_amount' => request('receipt'),
                 'user_id' => auth()->user()->id,
                 'status'  => 1,
                'branch_id'  => $branch->id,
            ]);

            $project->logs()->create([
                'type' => $head,
                'type_id' => $receipt_ar->id,
                'user_id' => auth()->user()->id,
                'note' => 'สร้าง ' . $head
            ]);

            foreach (request('interim_payment_list') as $i => $interim_payment_list_id) {

                $interim_payment_list = Income::find($interim_payment_list_id);
                $interim_payment_list->receive_price = $interim_payment_list->receive_price + request('receipt_amount')[$i];
                $interim_payment_list->update();

                ReceiptArList::create([
                    'receipt_ar_id' => $receipt_ar->id,
                    'project_invoice_id' => request('invoice_ar')[$i],
                    'income_id' => $interim_payment_list->id,
                    'receipt' => request('receipt_amount')[$i],
                ]);
            }

            foreach (array_unique(request('invoice_ar')) as $invoice_ar_id) {
                $invoice_ar = ProjectInvoice::find($invoice_ar_id);
                if($invoice_ar->incomes->sum('receive_price') == $invoice_ar->incomes->sum('sum_price_vat')){
                    $invoice_ar->update([
                        'status'=> 1
                    ]);
                }
            }

            return $receipt_ar;
        });

        return redirect('/receipt-ar/show/'. $receipt_ar->id);
    }

    public function index()
    {
        $from = request ('from') ? request ('from') : Carbon::today()->format('Y-m-01') ;
        $to = request ('to') ? request ('to') : Carbon::today()->format('Y-m-d') ;
        $receipt_ars = ReceiptAr::whereBetween('date',[$from , $to])->where('branch_id', auth()->user()->branch_id)->where('tax', 0)->get();

        return view('project.receipt.index', compact('receipt_ars','from','to'));
    }

    public function tax()
    {
        $from = request ('from') ? request ('from') : Carbon::today()->format('Y-m-01') ;
        $to = request ('to') ? request ('to') : Carbon::today()->format('Y-m-d') ;
        $receipt_ars = ReceiptAr::whereBetween('date',[$from , $to])->where('branch_id', auth()->user()->branch_id)->where('tax', 1)->get();

        return view('project.receipt.tax', compact('receipt_ars','from','to'));
    }

    public function finish()
    {
        $project_id = request('project_id') ? request('project_id') : 'all';
        $from = request('from') ? request('from') : Carbon::today()->format('Y-01-01');
        $to = request('to') ? request('to') : Carbon::today()->format('Y-m-d');
        $projects = Project::get();
        $branchs = Branch ::where('show_project', 1)->get();
        $branchs_id = array();
        foreach($branchs as $branch){
            array_push($branchs_id, $branch->id);
        }

        $branchs_select = request('branchs_select') ? request('branchs_select') : $branchs_id;
 
        if ($project_id != 'all') {
            $receipt_ars = ReceiptAr::where('project_id', $project_id)->where('status', 1)->whereIn('branch_id',$branchs_select)->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:59'])->orderBy('date', 'DESC')->get();
        } else {
            $receipt_ars = ReceiptAr::where('status', 1)->whereIn('branch_id',$branchs_select)->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:59'])->orderBy('date', 'DESC')->get();
        }
        return view('project.receipt.finish', compact('receipt_ars','project_id','from','to','projects','branchs_select','branchs'));
    }

    public function show(ReceiptAr $receipt_ar)
    {
        if($receipt_ar->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        $project = $receipt_ar->project;

        return view('project.receipt.show', compact('receipt_ar', 'project'));
    }

    public function print(ReceiptAr $receipt)
    {
        if($receipt->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        return view('project.receipt.print', compact('receipt'));
    }

    public function approve(ReceiptAr $receipt)
    {
        if (!$receipt->user_approve_id) {
            $receipt->update([
                'user_approve_id' => auth()->user()->id
            ]);
            alert()->success('สำเร็จ', 'อนุมัติเรียบร้อย');
            return back();
        }
        return back();
    }

    public function cancel(ReceiptAr $receipt)
    {
        if ($receipt->status != 1) {
            alert()->error('ไม่สำเร็จ', 'สถานะไม่ถูกต้อง');
            return back();
        }

        if($receipt->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }

        DB::transaction(function () use ($receipt) {
            $project = $receipt->project;
            if ($project->vat_type == 'ไม่มี') {
                $head = 'REC-';
            } else {
                $head = 'BI-';
            }

            $project->logs()->create([
                'type' => $head,
                'type_id' => $receipt->id,
                'user_id' => auth()->user()->id,
                'note' => 'ยกเลิก ' . $receipt->code
            ]);

            foreach ($receipt->receipt_ar_list as $receipt_ar_list) {
                $receipt_ar_list->income->receive_price = $receipt_ar_list->income->receive_price - $receipt_ar_list->receipt;
                $receipt_ar_list->income->update();
            }

            $receipt->receipt_ar_list->first()->project_invoice->status = 0;
            $receipt->receipt_ar_list->first()->project_invoice->update();

            if($receipt->tax != 0){
                $ar_check = ReceiptAr::where('branch_id',auth()->user()->branch_id)->whereNotIn('tax',[0])->latest('id')->first();
                if($ar_check->id != $receipt->id){
                    $receipt->update([
                        'status'=>99,
                        'note'=>request('note')
                    ]);
                }else{
                    $receipt->delete();
                }
            }else{
                $ar_check = ReceiptAr::where('branch_id',auth()->user()->branch_id)->whereNotIn('tax',[1])->latest('id')->first();
                if($ar_check->id != $receipt->id){
                    $receipt->update([
                        'status'=>99,
                        'note'=>request('note')
                    ]);
                }else{
                    $receipt->delete();
                }
            }
  
        });

        return redirect('/project/add-income/new/'.$receipt->project_id);
    }
    
}
