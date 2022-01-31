<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\Project;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('branch_id',auth()->user()->branch_id)->get();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        $project = Null;
        return view('customers.create',compact('project'));
    }
    
    public function  create_project(Project $project)
    {
        if($project->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        if($project->customer){
            alert()->error('ผิดพลาด', 'มีลุกค้าอยู่แล้ว');
            return redirect('/project');
        }

        return view('customers.create',compact('project'));
    }

    public function show(Customer $customer)
    {
        if($customer->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        return view('customers.show', compact('customer'));
    }

    public function store()
    {
        if (!request('to_branchs')) {
            alert()->error('ผิดพลาด', 'ไม่ได้เลือกบริษัท');
            return back();
        }

        if(request('project_id')){
            $project = Project::find(request('project_id'));
            if($project->customer){
                alert()->error('ผิดพลาด', 'มีลุกค้าอยู่แล้ว');
                return redirect('/project');
            }
            foreach(request('to_branchs') as $to_branch){
                $customer = Customer::create(request()->all());
                $customer->update([
                  'branch_id'=>$to_branch
                ]);
              }
              $project->update([
                  'customer_id'=>$customer->id
              ]);
              alert()->success('สำเร็จ', 'เพิ่มลูกค้า เรียบร้อย');
              return redirect('/project/show/'.$project->id);
        }

        DB::transaction(function () {
            foreach(request('to_branchs') as $to_branch){
              $customer = Customer::create(request()->all());
              $customer->update([
                'branch_id'=>$to_branch
              ]);
            }
        });

        alert()->success('สำเร็จ', 'เพิ่มลูกค้า เรียบร้อย');
        return redirect('/customers');
    }

    public function update(Customer $customer)
    {
        DB::transaction(function () use ($customer) {
            $customer->update(request()->all());

            alert()->success('สำเร็จ', 'แก้ไขข้อมูลูกค้า เรียบร้อย');
        });

        return back();
    }
}
