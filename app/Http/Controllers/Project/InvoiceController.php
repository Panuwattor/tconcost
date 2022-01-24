<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Project;
use App\Income;
use App\ProjectInvoice;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index()
    {
        if(request('status')){
        $invoices = ProjectInvoice::with('user','project','project.customer')->orderBy('created_at','desc')->get();
        }else{
        $invoices = ProjectInvoice::where('status', 0)->get();
        }

        return view('project.invoice.index', compact('invoices'));
    }
    
    public function show(ProjectInvoice $invoice)
    {
        $project = $invoice->project;
        return view('project.invoice.show', compact('invoice','project'));
    }

    public function print(ProjectInvoice $invoice)
    {
        return view('project.invoice.print', compact('invoice'));
    }

    public function create(Project $project)
    {
        if (!request('incomes')) {
            alert()->error('ผิดพลาด', 'เลือกรายการก่อน');
            return back();
        }
        $incomes = Income::whereIn('id', request('incomes'))->where('status', 0)->get();
        return view('project.invoice.create', compact('project', 'incomes'));
    }

    public function store(Project $project)
    {

        $invoice = DB::transaction(function () use ($project) {
            $branch = $project->branch;
            $count = ProjectInvoice::whereBetween('date', [Carbon::createFromFormat('Y-m-d', request('date'))->format('Y-m-01') . ' 00:00:00', Carbon::createFromFormat('Y-m-d', request('date'))->format('Y-m-t') . ' 23:59:59'])->where('branch_id', $branch->id)->count();
            $code = 'IN' . $branch->code . Carbon::createFromFormat('Y-m-d', request('date'))->format('ym') . sprintf("%'04d", $count + 1);
            $over = Carbon::createFromFormat('Y-m-d H:i:s', request('date') . ' 00:00:00')->addDays(request('cradit') ? request('cradit') : 0)->format('Y-m-d');
            $incomes = Income::whereIn('id', request('incomes'))->where('status', 0)->get();

            $invoice = ProjectInvoice::create([
                'project_id' => $project->id,
                'branch_id' => $branch->id,
                'date' => request('date'),
                'code' => $code,
                'note' => request('note'),
                'payment_condition' => request('payment_condition'),
                'credit_amount' => request('cradit'),
                'credit_note' => request('note'),
                'credit_date' => $over,
                'status' => 0,
                'user_id' => auth()->user()->id,
                'discount' => request('discount'),
                'vat_type' => $project->vat_type,
                'tax_base' => request('tax_base'),
                'vat_amount' => request('vat_amount'),
                'total' => request('total'),
            ]);

            foreach($incomes as $income){
                $_vat = 0;
                $_price_before_vat = 0;
                $_sum_price_vat = 0;

                if($income->project->vat_type == 'นอก'){
                    $_vat = $income->total * 0.07;
                    $_price_before_vat = $income->total;
                    $_sum_price_vat = $_vat + $_price_before_vat;
                }else if($income->project->vat_type == 'ใน'){
                    $_vat = $income->total - ($income->total / 1.07);
                    $_price_before_vat = $income->total / 1.07;
                    $_sum_price_vat = $_vat + $_price_before_vat;
                }else{
                    $_price_before_vat = $income->total;
                    $_sum_price_vat = $income->total;
                }

                $income->update([
                    'invoice_id'=>$invoice->id,
                    'status'=>1,
                    'vat'=>$_vat,
                    'price_before_vat'=>$_price_before_vat,
                    'sum_price_vat'=>$_sum_price_vat
                    ]);
            }

            $project->logs()->create([
                'type' => 'AR',
                'type_id' => $invoice->id,
                'user_id' => auth()->user()->id,
                'note' => 'สร้าง AR'
            ]);

            return $invoice;
        });

        return redirect('/project/invoice/show/' . $invoice->id);
    }

    public function cancel(ProjectInvoice $invoice)
    {
            if($invoice->status != 0){
                alert()->error('ไม่สำเร็จ', 'สถานะไม่ถูกต้อง');
                return back();
            }
            $project_id = DB::transaction(function () use ($invoice) {
            $project_id = $invoice->project_id;
            foreach($invoice->incomes as $income){
                $income->update([
                    'invoice_id'=>Null,
                    'status'=>0,
                    'vat'=>0,
                    'price_before_vat'=>0,
                    'sum_price_vat'=>0
                    ]);
            }

            $invoice->project->logs()->create([
                'type' => 'AR',
                'type_id' => $invoice->id,
                'user_id' => auth()->user()->id,
                'note' => 'ยกเลิก AR'
            ]);

            $invoice->delete();

            return $project_id;
        });

        alert()->success('สำเร็จ', 'ยกเลิกแล้ว');
        return redirect('/project/add-income/new/'.$project_id);
    }
}
