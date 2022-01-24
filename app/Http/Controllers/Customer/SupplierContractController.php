<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\SupplierContract;
use DB;

class SupplierContractController extends Controller
{
    public function index(Customer $supplier)
    {
        return view('customers.supplier_show', compact('supplier'));
    }

    public function store(Customer $supplier)
    {
        DB::transaction(function() use ($supplier){
            $request = request()->all();
            $request['customer_id'] = $supplier->id;
            $request['status'] = 1;

            SupplierContract::create($request);
        });

        return back();
    }

    public function getContract()
    {
        $supplier = Customer::find(request('supplier_id'));
        return response()->json($supplier->contracts->where('status',1));
    }
   
    public function getSupplier()
    {
        $supplier = Customer::find(request('supplier_id'));
        return response()->json($supplier);
    }

    public function edit(SupplierContract $contract)
    {
        DB::transaction(function() use ($contract){
            $request = request()->all();
            $contract->update($request);
        });

        return back();
    }
}
