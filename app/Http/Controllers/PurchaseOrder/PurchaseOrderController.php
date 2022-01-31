<?php

namespace App\Http\Controllers\PurchaseOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\PoFile;
use App\AllocateList;
use App\PoListNote;
use App\PurchaseOrder;
use App\Project;
use App\PurchaseOrderList;
use App\User;
use App\UserToBranch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $pos = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')->where('branch_id',auth()->user()->branch_id)->whereIn('po_type', ['PO'])->where('status', 0)->get();
        return view('po.index', compact('pos'));
    }

    public function index_sc()
    {
        $pos = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')->where('branch_id',auth()->user()->branch_id)->whereIn('po_type', ['SC'])->where('status', 0)->get();
        return view('po.index_sc', compact('pos'));
    }
    
    public function approves()
    {
        $pos = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')->where('branch_id',auth()->user()->branch_id)->whereIn('po_type', ['PO'])->where('status', 1)->get();
        return view('po.index', compact('pos'));
    }

    public function approves_sc()
    {
        $pos = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')->where('branch_id',auth()->user()->branch_id)->whereIn('po_type', ['SC'])->where('status', 1)->get();
        return view('po.index_sc', compact('pos'));
    }
    
    public function cancels()
    {
        $pos = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')->where('branch_id',auth()->user()->branch_id)->whereIn('po_type', ['PO'])->where('status', 2)->get();
        return view('po.index', compact('pos'));
    }

    public function cancels_sc()
    {
        $pos = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')->where('branch_id',auth()->user()->branch_id)->whereIn('po_type', ['SC'])->where('status', 2)->get();
        return view('po.index_sc', compact('pos'));
    }
    
    public function create($type)
    {
        $projects = Project::where('status', '!=', 0)->where('branch_id',auth()->user()->branch_id)->get();
        $main_users = UserToBranch::where('branch_id',auth()->user()->branch_id)->get();
        $suppliers = Customer::whereIn('status', ['supplier','customer , supplier' ,'customer'])->where('branch_id',auth()->user()->branch_id)->get();

        if($type == 'NR'){
            return view('po.nr_create', compact('projects', 'main_users', 'suppliers', 'type'));
        }else{
            return view('po.create', compact('projects', 'main_users', 'suppliers', 'type'));
        }
    }

    public function store()
    {
        $po_id = DB::transaction(function () {

            if(request('new_customer_id')){
                $customer_id = request('new_customer_id');
             }else{
                if(!request('customer_name')){
                    return 0;
                 }
                $customer = Customer::create([
                 'name'=> request('customer_name'),
                 'tel'=> request('customer_tel'),
                 'fax'=> request('customer_fax'),
                 'address'=> request('customer_address'),
                 'note'=> request('customer_note'),
                 'status'=> request('customer_status'),
                 'txt_tin'=> request('customer_txt_tin'),
                 'email'=> request('customer_email'),
                 'branch_id'=> auth()->user()->branch_id,
                ]);
                $customer_id = $customer->id;
             }

            $project = Project::find(request('project_id'));
            $count = PurchaseOrder::where('po_type', request('po_type'))
                                    ->whereBetween('po_date', [Carbon::createFromFormat('Y-m-d', request('po_date'))->format('Y-m-01') . ' 00:00:00', Carbon::createFromFormat('Y-m-d', request('po_date'))->format('Y-m-t') . ' 23:59:59'])
                                    ->where('project_id', $project->id)->count();
            $code = request('po_type') . $project->code . Carbon::createFromFormat('Y-m-d', request('po_date'))->format('ym') . sprintf("%'03d", $count + 1);
            $requests = request()->all();
            $requests['user_id'] = auth()->user()->id;
            $requests['branch_id'] = auth()->user()->branch_id;
            $requests['po_type'] = request('po_type');
            $requests['code'] = $code;
            $requests['supplier_id'] = $customer_id;

            $po = PurchaseOrder::create($requests);

            if (request('pofile')) {
                foreach (request('pofile') as $file) {
                    $file = Storage::disk('spaces')->putFile('tconcost/branch/'.auth()->user()->branch_id.'/project/'.$project->id, $file, 'public');
                    PoFile::create([
                        'purchase_order_id' => $po->id,
                        'file' => $file,
                    ]);
                }
            }

            if (request('photo')) {
            } else {
                $file = Null;
            }
    
            foreach (request('name') as $i => $name) {
                 PurchaseOrderList::create([
                    'purchase_order_id' => $po->id,
                    'name' => $name,
                    'amount' => request('amount')[$i],
                    'unit' => request('unit')[$i],
                    'unit_price' => request('unit_price')[$i],
                    'unit_discount' => request('unit_discount')[$i],
                    'price' => request('price')[$i],
                    'special_discount' => request('list_special_discount')[$i],
                ]);
            }

            $project->logs()->create([
                'type' => 'PO',
                'type_id' => $po->id,
                'user_id' => auth()->user()->id,
                'note' => 'สร้าง ' . request('po_type')
            ]);

            return  $po->id;
        });
        if($po_id == 0){
            alert()->error('ผิดพลาด', 'ไม่ได้เพิ่มลูกค้า');
            return back();
        }
        if (request('po_type') == 'NR') {
            return redirect('/po/nr');
        } else {
            return redirect('/po/show/' . $po_id);
        }
    }
    
    public function show(PurchaseOrder $po)
    {
        if($po->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        return view('po.show', compact('po'));
    }

    public function print(PurchaseOrder $po)
    {
        if($po->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        return view('po.print', compact('po'));
    }

    public function group_cost()
    {
        $pro_id = request('pro_id');
        if ($pro_id) {
            $pro = Project::find($pro_id);
            $cost_plan_list = $cost_plan_list = $pro->cost_plans()->where('cost','>',0)->get();
            foreach ($cost_plan_list as $on => $list) {
                $cost_plan_list[$on]['cost_plan_name'] = $list->cost_plan->name;
                $cost_plan_list[$on]['costPlanLists'] = $list->cost_plan_list->name;
            }

            return response()->json($cost_plan_list);
        }
    }

    public function allocate_search()
    {
        $pro_id = request('pro_id');
        $value = request('value');

        if ($pro_id) {
            $pro = Project::find($pro_id);

            if(is_numeric($value)){
                $cost_plan_list = DB::table('project_cost_plan_lists')
                ->where('project_cost_plan_lists.project_cost_plan_id', $pro->projectCostPlan->id)
                ->join('cost_plans', 'project_cost_plan_lists.cost_plan_id', '=', 'cost_plans.id')
                ->join('cost_plan_lists', 'project_cost_plan_lists.cost_plan_list_id', '=', 'cost_plan_lists.id')
                ->Where('cost_plans.id', 'like', '%' . $value . '%')
                ->select('project_cost_plan_lists.*')
                ->get();
            }else{
                $cost_plan_list = DB::table('project_cost_plan_lists')
                ->where('project_cost_plan_lists.project_cost_plan_id', $pro->projectCostPlan->id)
                ->join('cost_plans', 'project_cost_plan_lists.cost_plan_id', '=', 'cost_plans.id')
                ->join('cost_plan_lists', 'project_cost_plan_lists.cost_plan_list_id', '=', 'cost_plan_lists.id')
                ->where('cost_plan_lists.name', 'like', '%' . $value . '%')
                ->select('project_cost_plan_lists.*')
                ->get();
            }

            $project_cost_plan_lists = [];
            foreach ($cost_plan_list as $on => $list) {
                $p = ProjectCostPlanList::find($list->id);
                $project_cost_plan_lists[$on] = $p;
                $project_cost_plan_lists[$on]['cost_plan_name'] = $p->cost_plan->name;
                $project_cost_plan_lists[$on]['costPlanLists'] = $p->costPlanLists->name;
            }

            return response()->json($project_cost_plan_lists);
        }
    }

    public function allocate_edit(PurchaseOrderList $polist)
    {
        if($polist->po->status != 0){
            alert()->error('ผิดพลาด', 'สถานะนี้ไม่สามารถทำรายการได้');
            return redirect('/po/show/'.$polist->po->id);
        }
        $projects = Project::where('status', '!=', 0)->get();
        $allocate_list = $polist->allocate->allocate_list;
        foreach ($allocate_list as $i => $list) {
            $allocate_list[$i]['cost_plan_name'] = $list->project_cost_plan_list->cost_plan->name;
            $allocate_list[$i]['costPlanLists'] = $list->project_cost_plan_list->cost_plan_list->name;
        }
        if($polist->po->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        return view('po.allocate_edit', compact('polist', 'projects', 'allocate_list'));
    }

    public function approve(PurchaseOrder $po)
    {

        foreach($po->purchaseOrderLists as $list){
            if(!$list->allocate){
                alert()->error('ไม่สำเร็จ', 'มีรายการไม่ได้จัดสรร');
                return back();
            }
        }
        $po->update([
            'status'=>1
        ]);
        alert()->success('สำเร็จ', 'อนุมัติเรียบร้อย');
        return view('po.show', compact('po'));
    }

    public function cancel(PurchaseOrder $po)
    {

        DB::transaction(function () use ($po) {

            foreach($po->purchaseOrderLists as $list){
                $_allocate_lists = AllocateList::where('allocate_id', $list->allocate->id)->where('project_id', $list->po->project_id)->get();
                foreach ($_allocate_lists as $allocate_list) {
                    $price_vat = 0;
                    if ($list->po->vat_type == 'นอก') {
                        $allocate_list->project_cost_plan_list->update([
                            'use_cost'=>$allocate_list->project_cost_plan_list->use_cost - ($allocate_list->price + ($allocate_list->price * 0.07))
                        ]);
    
                        $price_vat = $allocate_list->price + ($allocate_list->price * 0.07);
                    } else {
                        $allocate_list->project_cost_plan_list->update([
                            'use_cost'=>$allocate_list->project_cost_plan_list->use_cost - $allocate_list->price
                        ]);
    
                        $price_vat = $allocate_list->price;
                    }
                }
    
                foreach ($list->allocate->allocate_list as $list) {
                    $list->delete();
                }
                $list->allocate->delete();
            }
            $po->update([
                'status'=>2
            ]);
        });


        alert()->success('สำเร็จ', 'ยกเลิกเรียบร้อย');
        return back();
    }
    
    public function search_report()
    {
        $from = request ('from');
        $to = request ('to');
        $date_type = request('date_type');
        $projects = Project::get();
        $types = ['PO'];
        $project_id = request('project_id') ? request('project_id') :'all';
        $status = request('status') ? request('status') : [0,1,2,5,6];
        
        if($project_id != 'all' && $date_type == 'date'){
                $data = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')
                ->where('project_id', $project_id)
                ->whereIn('po_type', $types)
                ->whereBetween('po_date', [$from, $to])
                ->whereIn('status', $status)
                ->orderBy('po_date', 'DESC')->where('branch_id',auth()->user()->branch_id)
                ->get();
        }else if($project_id != 'all' && $date_type == 'create_date'){
            $data = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')
            ->where('project_id', $project_id)
            ->whereIn('po_type', $types)
            ->whereIn('status', $status)
            ->whereBetween('created_at', [$from . ' 00:00:00', $to .' 23:59:59'])
            ->orderBy('created_at', 'DESC')->where('branch_id',auth()->user()->branch_id)
            ->get();

        }else if($project_id == 'all' && $date_type == 'date' && $types != []) {
            $data = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')
                ->whereIn('po_type', $types)
                ->whereIn('status', $status)
                ->whereBetween('po_date', [$from, $to])
                ->orderBy('po_date', 'DESC')->where('branch_id',auth()->user()->branch_id)
                ->get();
        }else if($project_id == 'all' && $date_type == 'create_date' && $types != []){
                $data = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')
                ->whereBetween('created_at', [$from . ' 00:00:00', $to .' 23:59:59'])
                ->whereIn('status', $status)
                ->orderBy('created_at', 'DESC')->where('branch_id',auth()->user()->branch_id)
                ->get();
        }

        return view('po.search_report', compact('data', 'projects', 'types', 'from', 'to', 'date_type', 'project_id','status'));
    }

    public function search_report_sc()
    {
        $from = request ('from');
        $to = request ('to');
        $date_type = request('date_type');
        $projects = Project::get();
        $types = ['SC'];
        $project_id = request('project_id') ? request('project_id') :'all';
        $status = request('status') ? request('status') : [0,1,2,5,6];
        
        if($project_id != 'all' && $date_type == 'date'){
                $data = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')
                ->where('project_id', $project_id)
                ->whereIn('po_type', $types)
                ->whereBetween('po_date', [$from, $to])
                ->whereIn('status', $status)
                ->orderBy('po_date', 'DESC')->where('branch_id',auth()->user()->branch_id)
                ->get();
        }else if($project_id != 'all' && $date_type == 'create_date'){
            $data = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')
            ->where('project_id', $project_id)
            ->whereIn('po_type', $types)
            ->whereIn('status', $status)
            ->whereBetween('created_at', [$from . ' 00:00:00', $to .' 23:59:59'])
            ->orderBy('created_at', 'DESC')->where('branch_id',auth()->user()->branch_id)
            ->get();

        }else if($project_id == 'all' && $date_type == 'date' && $types != []) {
            $data = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')
                ->whereIn('po_type', $types)
                ->whereIn('status', $status)
                ->whereBetween('po_date', [$from, $to])
                ->orderBy('po_date', 'DESC')->where('branch_id',auth()->user()->branch_id)
                ->get();
        }else if($project_id == 'all' && $date_type == 'create_date' && $types != []){
                $data = PurchaseOrder::with('user', 'main_user', 'project', 'supplier')
                ->whereBetween('created_at', [$from . ' 00:00:00', $to .' 23:59:59'])
                ->whereIn('status', $status)
                ->orderBy('created_at', 'DESC')->where('branch_id',auth()->user()->branch_id)
                ->get();
        }

        return view('po.search_report_sc', compact('data', 'projects', 'types', 'from', 'to', 'date_type', 'project_id','status'));
    }

    public function copy(PurchaseOrder $po)
    {

        $projects = Project::where('status', '!=', 0)->where('branch_id',auth()->user()->branch_id)->get();
        $main_users = UserToBranch::where('branch_id',auth()->user()->branch_id)->get();
        $suppliers = Customer::whereIn('status', ['supplier','customer , supplier','customer'])->where('branch_id',auth()->user()->branch_id)->get();
        $type = $po->po_type;

        $files = array();
        foreach ($po->poFiles as $file) {
            array_push($files, $file);
        }
        $files = json_encode($files);

        foreach($po->purchaseOrderLists as $ix => $purchaseOrderList){
            $po->purchaseOrderLists[$ix]['list_note'] = $purchaseOrderList->listNotes;
        }

        if($type == 'NR'){
            return view('po.nr_copy', compact('projects', 'main_users', 'suppliers', 'type', 'po', 'files'));
        }else{
            return view('po.copy', compact('projects', 'main_users', 'suppliers', 'type', 'po', 'files'));
        }
    }

    public function cancle(PurchaseOrder $po)
    {
        DB::transaction(function () use ($po) {
            foreach ($po->purchaseOrderLists as $po_list) {
                if ($po_list->allocate) {
                    foreach ($po_list->allocate->allocate_list as $allocate_list) {
                        $price_vat = 0;
                        if ($po->vat_type == 'นอก') {
                            $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost - ($allocate_list->price + ($allocate_list->price * 0.07));
                            $allocate_list->project_cost_plan_list->update();
                            $price_vat = $allocate_list->price + ($allocate_list->price * 0.07);
                        } else {
                            $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost - $allocate_list->price;
                            $allocate_list->project_cost_plan_list->update();
                            $price_vat = $allocate_list->price;
                        }

                        $allocate_list->delete();
                    }
                    $po_list->allocate->delete();
                }
            }

            $po->status = 4;
            $po->update();
            $po->project->logs()->create([
                'type' => 'PO',
                'type_id' => $po->id,
                'user_id' => auth()->user()->id,
                'note' => 'ยกเลิก ' . $po->po_type
            ]);
        });
        return back();
    }

    public function edit(PurchaseOrder $po)
    {
        $projects = Project::where('status', '!=', 0)->get();
        $main_users = User::all();
        $suppliers = Customer::whereIn('status', ['supplier','customer , supplier'])->get();
        $type = $po->po_type;

        $files = array();
        foreach ($po->poFiles as $file) {
            array_push($files, $file);
        }
        $files = json_encode($files);

        foreach($po->purchaseOrderLists as $ix => $purchaseOrderList){
            $po->purchaseOrderLists[$ix]['list_note'] = $purchaseOrderList->listNotes;
        }

        return view('po.edit', compact('projects', 'main_users', 'suppliers', 'type', 'po', 'files'));
    }

    public function update()
    {
        $po = DB::transaction(function () {
            $po = PurchaseOrder::find(request('id'));
            if ($po->status != 0) {
                alert()->error('ผิดพลาด', 'ไม่สามารถแก้ไขได้');
                return;
            }

            $po->update(request()->all());

            if (request('pofile')) {
                foreach (request('pofile') as $file) {
                    $file = $file->store('po/'.$po->id, 'public');
                    PoFile::create([
                        'purchase_order_id' => $po->id,
                        'file' => $file,
                    ]);
                }
            }
            
            foreach (request('name') as $i => $name) {
                if(request('po_lists_id')[$i]){
                    $po_list = PurchaseOrderList::find(request('po_lists_id')[$i]);
                    $po_list->name = $name;
                    $po_list->amount = request('amount')[$i];
                    $po_list->unit = request('unit')[$i];
                    $po_list->unit_price = request('unit_price')[$i];
                    $po_list->unit_discount = request('unit_discount')[$i];
                    $po_list->price = request('price')[$i];
                    $po_list->special_discount = request('list_special_discount')[$i];
                    $po_list->update();
                }else{
                    $po_list = PurchaseOrderList::create([
                        'purchase_order_id' => $po->id,
                        'name' => $name,
                        'amount' => request('amount')[$i],
                        'unit' => request('unit')[$i],
                        'unit_price' => request('unit_price')[$i],
                        'unit_discount' => request('unit_discount')[$i],
                        'price' => request('price')[$i],
                        'special_discount' => request('list_special_discount')[$i],
                        'vat' => request('vat')[$i],
                    ]);
                }
            }

            $po->project->logs()->create([
                'type' => 'PO',
                'type_id' => $po->id,
                'user_id' => auth()->user()->id,
                'note' => 'แก้ไข ' . request('po_type')
            ]);

            return $po;
        });

        return redirect('/po/show/' . $po->id);
    }

    public function sertAdd(Project $project)
    {
        return $project->address;
    }
    
}
