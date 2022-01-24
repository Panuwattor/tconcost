<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Quotation;
use App\Project;
use App\Customer;
use App\ProjectType;
use App\Branch;
use Carbon\Carbon;
use DB;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::with('user', 'customer')->orderBy('created_at', 'desc')->get();
        return view('quotation.index', compact('quotations'));
    }

    public function create()
    {
        $users = User::all();
        $customers = Customer::whereIn('status',[ 'customer','customer , supplier'])->get();
        $projects = Project::with('main_user', 'customer')->orderBy('created_at', 'desc')->get();
        $branchs = Branch::where('status', 1)->get();
        $project_types = ProjectType::all();
        return view('quotation.create', compact('customers', 'project_types', 'users', 'projects', 'branchs'));
    }
   
    public function store()
    {
        DB::transaction(function () {

            if(request('customer_id')){
               $customer_id = request('customer_id');
            }else{
               $customer = Customer::create([
                'name'=> request('customer_name'),
                'tel'=> request('customer_tel'),
                'fax'=> request('customer_fax'),
                'address'=> request('customer_address'),
                'note'=> request('customer_note'),
                'status'=> request('customer_status'),
                'txt_tin'=> request('customer_txt_tin'),
                'email'=> request('customer_email')
               ]);
               $customer_id = $customer->id;
            }
            $count_code = Quotation::where('year', Carbon::today()->format('Ym'))->count();
            $code = 'QT'.Carbon::today()->format('Ym').sprintf("%'03d", $count_code + 1);
            $quotation = Quotation::create([
                'name'=> request('name'),
                'project_id'=> Null,
                'customer_id'=> $customer_id,
                'project_type_id'=> request('project_type_id'),
                'code'=> $code,
                'year'=> Carbon::today()->format('Ym'),
                'general'=> Null,
                'type'=> request('type'),
                'project_cost'=> 0,
                'vat'=> request('vat'),
                'address'=> request('address_project'),
                'vat_type'=> request('vat_type'),
                'start_date'=> request('start_date'),
                'finish_date'=> request('finish_date'),
                'note'=> request('note'),
                'user_id'=> auth()->user()->id,
                'main_user_id'=> auth()->user()->id,
                'status'=> 1,
                'branch_id'=> request('branch_id'),
            ]);
            foreach(request('dates') as $key => $date){
                if(request('vat_type') == 'นอก'){
                    $sum_price_vat =  ( (request('prices')[$key] * request('vat') ) / 100)  + request('prices')[$key];
                    $price_before_vat = request('prices')[$key];
                    $vat = (request('prices')[$key] * request('vat') ) / 100;

                }elseif(request('vat_type') == 'ใน'){
                    $sum_price_vat =  request('prices')[$key];
                    $price_before_vat = request('prices')[$key] / 1.07;
                    $vat = request('prices')[$key] - (request('prices')[$key] / 1.07);

                }else{
                    $sum_price_vat =  request('prices')[$key];
                    $price_before_vat = request('prices')[$key];
                    $vat = 0;
                }

                $quotation->lists()->create([
                    'type'=> 'งวดงาน',
                    'description'=> request('details')[$key],
                    'unit'=> request('units')[$key],
                    'date'=> $date,
                    'price'=> request('prices')[$key],
                    'percent'=> 0,
                    'discount'=> 0,
                    'total'=> request('prices')[$key],
                    'status'=> 0,
                    'receive_price'=> 0,
                    'vat'=> $vat,
                    'price_before_vat'=> $price_before_vat,
                    'sum_price_vat'=> $sum_price_vat,
                ]);
            }

            $quotation->update([
                'project_cost'=>$quotation->lists->sum('sum_price_vat')
            ]);
        });
            return redirect('/sale/quotations');
    }

    public function show(Quotation $quotation)
    {
        return view('quotation.show', compact('quotation'));
    }

    public function cancel(Quotation $quotation)
    {
        $quotation->update([
            'status'=>0
        ]);
        alert()->success('สำเร็จ', 'ยกเลิกเรียบร้อย');
        return back();
    }
    
    public function print(Quotation $quotation)
    {
        return view('quotation.print', compact('quotation'));
    }

    public function edit(Quotation $quotation)
    {
        $users = User::all();
        $customers = Customer::whereIn('status',[ 'customer','customer , supplier'])->get();
        $projects = Project::with('main_user', 'customer')->orderBy('created_at', 'desc')->get();
        $branchs = Branch::where('status', 1)->get();
        $project_types = ProjectType::all();
        return view('quotation.edit', compact('quotation','customers', 'project_types', 'users', 'projects', 'branchs'));
    }

    public function update(Quotation $quotation)
    {
        DB::transaction(function () use($quotation) {

            $quotation->update([
                'name'=> request('name'),
                'customer_id'=> request('customer_id'),
                'project_type_id'=> request('project_type_id'),
                'vat'=> request('vat'),
                'address'=> request('address_project'),
                'vat_type'=> request('vat_type'),
                'start_date'=> request('start_date'),
                'finish_date'=> request('finish_date'),
                'note'=> request('note'),
                'branch_id'=> request('branch_id'),
            ]);

            $quotation->lists()->delete();
            
            foreach(request('dates') as $key => $date){
                if(request('vat_type') == 'นอก'){
                    $sum_price_vat =  ( (request('prices')[$key] * request('vat') ) / 100)  + request('prices')[$key];
                    $price_before_vat = request('prices')[$key];
                    $vat = (request('prices')[$key] * request('vat') ) / 100;

                }elseif(request('vat_type') == 'ใน'){
                    $sum_price_vat =  request('prices')[$key];
                    $price_before_vat = request('prices')[$key] / 1.07;
                    $vat = request('prices')[$key] - (request('prices')[$key] / 1.07);

                }else{
                    $sum_price_vat =  request('prices')[$key];
                    $price_before_vat = request('prices')[$key];
                    $vat = 0;
                }

                $quotation->lists()->create([
                    'type'=> 'งวดงาน',
                    'description'=> request('details')[$key],
                    'unit'=> request('units')[$key],
                    'date'=> $date,
                    'price'=> request('prices')[$key],
                    'percent'=> 0,
                    'discount'=> 0,
                    'total'=> request('prices')[$key],
                    'status'=> 0,
                    'receive_price'=> 0,
                    'vat'=> $vat,
                    'price_before_vat'=> $price_before_vat,
                    'sum_price_vat'=> $sum_price_vat,
                ]);
            }

            $quotation->update([
                'project_cost'=>$quotation->lists->sum('sum_price_vat')
            ]);
        });

        return redirect("/sale/quotation/{$quotation->id}/show");
    }
    
    public function project(Quotation $quotation)
    {
        if($quotation->status != 1){
            alert()->error('ผิดพลาด', 'ทำรายการไม่ได้');
            return back();
        }
        $project = DB::transaction(function () use($quotation) {

            $branch = $quotation->branch;
            $year = Carbon::today()->format('y');
            $project_count = Project::where('branch_id', $branch->id)->where('year', $year)->count() + 1;
            $code = $branch->code . '-' . $year . sprintf("%'02d", $project_count);

                    $project = Project::create([
                        'name'=> $quotation->name,
                        'customer_id'=> $quotation->customer_id,
                        'project_type_id'=> $quotation->project_type_id,
                        'code'=> $code,
                        'year'=> $year,
                        'general'=> $quotation->general,
                        'project_cost'=> $quotation->project_cost,
                        'vat'=> $quotation->vat,
                        'address'=> $quotation->address,
                        'vat_type'=> $quotation->vat_type,
                        'start_date'=> $quotation->start_date,
                        'finish_date'=> $quotation->finish_date,
                        'note'=> $quotation->note,
                        'user_id'=> auth()->user()->id,
                        'main_user_id'=> $quotation->main_user_id,
                        'status'=> $quotation->status,
                        'branch_id'=> $quotation->branch_id,
                        'type'=> $quotation->type
                    ]);

                    $project->logs()->create([
                        'type' => 'project',
                        'type_id' => $project->id,
                        'user_id' => auth()->user()->id,
                        'note' => 'สร้าง'
                    ]);

                    foreach($quotation->lists as $list){
                        $percent = ($list->price * 100) / $quotation->project_cost;
                        $project->incomes()->create([
                            'type'=> $list->type,
                            'description'=> $list->description,
                            'unit'=> $list->unit,
                            'date'=> $list->date,
                            'price'=> $list->price,
                            'percent'=> $percent,
                            'discount'=> 0,
                            'total'=> $list->total,
                            'note'=> $list->note,
                            'status'=> $list->status,
                            'receive_price'=> $list->receive_price,
                            'vat'=> $list->vat,
                            'price_before_vat'=> $list->price_before_vat,
                            'sum_price_vat'=>$list->sum_price_vat
                        ]);
                    }
                    $quotation->update([
                        'project_id'=>$project->id,
                        'status'=>4
                    ]);
                    return $project;
                });
        alert()->success('สำเร็จ', 'สร้างรายการเรียบร้อย');
        return redirect("/project/show/{$project->id}");
    }
    
}
