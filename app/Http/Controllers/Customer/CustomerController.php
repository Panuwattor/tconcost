<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function show(Customer $customer)
    {
        return view('customers.show',compact('customer'));
    }

    public function store()
    {
        $customer = DB::transaction(function () {
            $customer = Customer::create(request()->all());
            return $customer;
        });

        alert()->success('สำเร็จ', 'เพิ่มลูกค้า เรียบร้อย');
        return redirect('/customer/'.$customer->id.'/show');
    }

    public function update(Customer $customer)
    {
        DB::transaction(function() use ($customer){
            $customer->update(request()->all());
            
            alert()->success('สำเร็จ', 'แก้ไขข้อมูลูกค้า เรียบร้อย');
        });

        return back();
    }
}
