<?php

namespace App\Http\Controllers\Allocate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Allocate;
use App\AllocateList;
use App\Project;
use App\PurchaseOrderList;
use DB;

class AllocateController extends Controller
{
    public function store()
    {
        $polist = PurchaseOrderList::find(request('po_list_id'));
        DB::transaction(function () use ($polist) {
            if ($polist->allocate) {
                alert()->error('ไม่สำเร็จ', 'จัดสรรทรัพยากรณ์แล้ว');

                return;
            }

            $allocate = Allocate::create(request()->all());

            foreach (request('price') as $i => $price) {
                AllocateList::create([
                    'allocate_id' => $allocate->id,
                    'project_id' => request('project_id')[$i],
                    'project_cost_plan_list_id' => request('project_cost_plan_list_id')[$i],
                    'price' => request('price')[$i],
                ]);
            }

            foreach ($allocate->allocate_list as $allocate_list) {
                $price_vat = 0;
                if($polist->po->po_type == 'NR'){
                    if ($polist->po->vat_type == 'นอก' && $polist->vat == 'มี') {
                        $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost + $allocate_list->price + ($allocate_list->price * 0.07);
                        $allocate_list->project_cost_plan_list->update();
    
                        $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost = $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost + $allocate_list->price + ($allocate_list->price * 0.07);
                        $allocate_list->project_cost_plan_list->project_cost_plan->update();
    
                        $price_vat = $allocate_list->price + ($allocate_list->price * 0.07);
                    } else {
                        $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost + $allocate_list->price;
                        $allocate_list->project_cost_plan_list->update();
    
                        $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost = $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost + $allocate_list->price;
                        $allocate_list->project_cost_plan_list->project_cost_plan->update();
    
                        $price_vat = $allocate_list->price;
                    }
                }else{
                    if ($polist->po->vat_type == 'นอก') {
                        $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost + $allocate_list->price + ($allocate_list->price * 0.07);
                        $allocate_list->project_cost_plan_list->update();
    
                        $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost = $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost + $allocate_list->price + ($allocate_list->price * 0.07);
                        $allocate_list->project_cost_plan_list->project_cost_plan->update();
    
                        $price_vat = $allocate_list->price + ($allocate_list->price * 0.07);
                    } else {
                        $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost + $allocate_list->price;
                        $allocate_list->project_cost_plan_list->update();
    
                        $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost = $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost + $allocate_list->price;
                        $allocate_list->project_cost_plan_list->project_cost_plan->update();
    
                        $price_vat = $allocate_list->price;
                    }
                }
            }

            alert()->success('สำเร็จ', 'จัดสรรทรัพยากรณ์แล้ว');
        });

        return redirect('/po/show/approve/' . $polist->po->id);
    }

    public function new_store()
    {

        $res = DB::transaction(function (){
            
            foreach(request('po_lists') as $po_list){
                $polist = PurchaseOrderList::find($po_list['id']);
                if ($polist->allocate) {
                    alert()->error('ไม่สำเร็จ', 'จัดสรรทรัพยากรณ์แล้ว');
                    return 'fail';
                }
            }
            
            foreach(request('po_lists') as $po_list){
                $polist = PurchaseOrderList::find($po_list['id']);
                $allocate = Allocate::create([
                    'po_list_id' => $polist->id, 
                ]);

                foreach($po_list['allocates'] as $_allocate){
                   $allocate_list = AllocateList::create([
                        'allocate_id' => $allocate->id,
                        'project_id' => $_allocate['project_id'],
                        'project_cost_plan_list_id' => $_allocate['project_cost_plan_list_id'],
                        'price' => $_allocate['price'],
                    ]);

                    $price_vat = 0;
                    if ($polist->po->vat_type == 'นอก') {
                        $allocate_list->project_cost_plan_list->update([
                            'use_cost'=>$allocate_list->project_cost_plan_list->use_cost + $allocate_list->price + ($allocate_list->price * 0.07)
                        ]);
                        $price_vat = $allocate_list->price + ($allocate_list->price * 0.07);
                    } else {
                        $allocate_list->project_cost_plan_list->update([
                            'use_cost'=>$allocate_list->project_cost_plan_list->use_cost + $allocate_list->price
                        ]);
                        $price_vat = $allocate_list->price;
                    }
                }
    
            }

            alert()->success('สำเร็จ', 'จัดสรรทรัพยากรณ์แล้ว');
            return 'success';
        });
        
        if($res == 'success'){
            return 'success';
        }else{
            return 'fail';
        }
    }

    public function nr_store()
    {
        $polist = PurchaseOrderList::find(request('po_list_id'));
        DB::transaction(function () use ($polist) {

            if ($polist->allocate) {
                alert()->error('ไม่สำเร็จ', 'จัดสรรทรัพยากรณ์แล้ว');

                return;
            }

            $allocate = Allocate::create(request()->all());

            foreach (request('price') as $i => $price) {
                AllocateList::create([
                    'allocate_id' => $allocate->id,
                    'project_id' => request('project_id')[$i],
                    'project_cost_plan_list_id' => request('project_cost_plan_list_id')[$i],
                    'price' => request('price')[$i],
                ]);
            }

            foreach ($allocate->allocate_list as $allocate_list) {
                $price_vat = 0;
                if ($polist->po->vat_type == 'นอก') {
                    $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost + $allocate_list->price + ($allocate_list->price * 0.07);
                    $allocate_list->project_cost_plan_list->update();

                    $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost = $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost + $allocate_list->price + ($allocate_list->price * 0.07);
                    $allocate_list->project_cost_plan_list->project_cost_plan->update();

                    $price_vat = $allocate_list->price + ($allocate_list->price * 0.07);
                } else {
                    $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost + $allocate_list->price;
                    $allocate_list->project_cost_plan_list->update();

                    $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost = $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost + $allocate_list->price;
                    $allocate_list->project_cost_plan_list->project_cost_plan->update();

                    $price_vat = $allocate_list->price;
                }
            }

            alert()->success('สำเร็จ', 'จัดสรรทรัพยากรณ์แล้ว');
        });

        return redirect('/po-nr/show/approve/' . $polist->po->id);
    }

    public function update()
    {
        $polist = PurchaseOrderList::find(request('po_list_id'));
        DB::transaction(function () use ($polist) {

            $_allocate_lists = AllocateList::where('allocate_id', $polist->allocate->id)->where('project_id', $polist->po->project_id)->get();
            foreach ($_allocate_lists as $allocate_list) {
                $price_vat = 0;
                if ($polist->po->vat_type == 'นอก') {
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

            foreach ($polist->allocate->allocate_list as $list) {
                $list->delete();
            }

            foreach (request('price') as $i => $price) {
                $allocate_list = AllocateList::create([
                    'allocate_id' => $polist->allocate->id,
                    'project_id' => request('project_id')[$i],
                    'project_cost_plan_list_id' => request('project_cost_plan_list_id')[$i],
                    'price' => request('price')[$i],
                ]);

                $price_vat = 0;
                if ($polist->po->vat_type == 'นอก') {
                    $allocate_list->project_cost_plan_list->update([
                        'use_cost' => $allocate_list->project_cost_plan_list->use_cost + ($allocate_list->price + ($allocate_list->price * 0.07))
                    ]);
                    $price_vat = $allocate_list->price + ($allocate_list->price * 0.07);
                } else {
                    $allocate_list->project_cost_plan_list->update([
                        'use_cost'=>$allocate_list->project_cost_plan_list->use_cost + $allocate_list->price
                    ]);
                    $price_vat = $allocate_list->price;
                }
            }

        });
        alert()->success('สำเร็จ', 'จัดสรรทรัพยากรณ์แล้ว');
        return redirect('/po/show/' . $polist->po->id);
    }

    public function nr_update()
    {
        $polist = PurchaseOrderList::find(request('po_list_id'));
        DB::transaction(function () use ($polist) {

            $_allocate_lists = AllocateList::where('allocate_id', $polist->allocate->id)->where('project_id', $polist->po->project_id)->get();
            foreach ($_allocate_lists as $allocate_list) {
                $price_vat = 0;
                if ($polist->po->vat_type == 'นอก') {
                    $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost - ($allocate_list->price + ($allocate_list->price * 0.07));
                    $allocate_list->project_cost_plan_list->update();

                    $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost = $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost - ($allocate_list->price + ($allocate_list->price * 0.07));
                    $allocate_list->project_cost_plan_list->project_cost_plan->update();

                    $price_vat = $allocate_list->price + ($allocate_list->price * 0.07);
                } else {
                    $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost - $allocate_list->price;
                    $allocate_list->project_cost_plan_list->update();

                    $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost = $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost - $allocate_list->price;
                    $allocate_list->project_cost_plan_list->project_cost_plan->update();

                    $price_vat = $allocate_list->price;
                }
            }

            foreach ($polist->allocate->allocate_list as $list) {
                $list->delete();
            }

            foreach (request('price') as $i => $price) {
                AllocateList::create([
                    'allocate_id' => $polist->allocate->id,
                    'project_id' => request('project_id')[$i],
                    'project_cost_plan_list_id' => request('project_cost_plan_list_id')[$i],
                    'price' => request('price')[$i],
                ]);
            }

            $_allocate_lists = AllocateList::where('allocate_id', $polist->allocate->id)->where('project_id', $polist->po->project_id)->get();
            foreach ($_allocate_lists as $allocate_list) {
                $price_vat = 0;
                if ($polist->po->vat_type == 'นอก') {
                    $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost + ($allocate_list->price + ($allocate_list->price * 0.07));
                    $allocate_list->project_cost_plan_list->update();

                    $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost = $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost + ($allocate_list->price + ($allocate_list->price * 0.07));
                    $allocate_list->project_cost_plan_list->project_cost_plan->update();

                    $price_vat = $allocate_list->price + ($allocate_list->price * 0.07);
                } else {
                    $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost + $allocate_list->price;
                    $allocate_list->project_cost_plan_list->update();

                    $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost = $allocate_list->project_cost_plan_list->project_cost_plan->total_use_cost + $allocate_list->price;
                    $allocate_list->project_cost_plan_list->project_cost_plan->update();

                    $price_vat = $allocate_list->price;
                }
            }

            alert()->success('สำเร็จ', 'จัดสรรทรัพยากรณ์แล้ว');
        });

        return redirect('/po-nr/show/approve/' . $polist->po->id);
    }

    public function new_allocate_index()
    {
        if (!request('po_lists_id')) {
            alert()->error('ผิดพลาด', 'ไม่ได้เลื่อกรายการที่จะจัดสรร');
            return back();
        }

        $po_lists = array();
        $po = '';
        foreach(request('po_lists_id') as $po_lists_id){
            $po_list = PurchaseOrderList::find($po_lists_id);
            $po = $po_list->po;
            array_push($po_lists, $po_list);
        }

        foreach($po_lists as $i => $_po_list){
            $pro = $_po_list->po->project;
            $cost_plan_list = $pro->cost_plans()->where('cost','>',0)->get();
            foreach ($cost_plan_list as $on => $list) {
                $cost_plan_list[$on]['cost_plan_name'] = $list->cost_plan->name;
                $cost_plan_list[$on]['costPlanLists'] = $list->cost_plan_list->name;
            }

            $po_lists[$i]['allocates'] = array();
            $po_lists[$i]['po'] = $_po_list->po;
            $po_lists[$i]['group_cost'] = $cost_plan_list;
            $po_lists[$i]['project'] = $_po_list->po->project;
            $po_lists[$i]['sum_price'] = 0;
        }
        $po_lists = json_encode($po_lists);
        $projects = Project::where('status', '!=', 0)->get();
        return view('po.new_allocate', compact('po_lists', 'projects', 'po'));
    }
}
