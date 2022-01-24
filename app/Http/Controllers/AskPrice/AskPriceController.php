<?php

namespace App\Http\Controllers\AskPrice;

use App\AskPrice;
use App\AskPriceLits;
use App\AskPriceSupplier;
use App\Customer;
use App\Project;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AskPriceController extends Controller
{
    public function index()
    {
        $ask_prices = AskPrice::orderBy('created_at','DESC')->get();
        return view('ask-prices.index', compact('ask_prices'));
    }
    
    public function expired()
    {
        $ask_prices = AskPrice::whereDate('finish_date', '<', Carbon::today()->format('Y-m-d'))->get();
        return view('ask-prices.expired', compact('ask_prices'));
    }
    
    public function create()
    {
        $projects = Project::where('status', '!=', 0)->where('type', 0)->get();
        $main_users = User::all();
        $suppliers = Customer::whereIn('status',[ 'supplier','customer , supplier'])->get();

        return view('ask-prices.create', compact('projects', 'main_users', 'suppliers'));
    }

    public function store()
    {
        DB::transaction(function(){
            $file = null;
            $req = request()->all();
    
            if (request('photo')) {
                $file = request('photo')->store('ask','public');
            } 
    
            $count = AskPrice::whereBetween('created_at', [Carbon::today()->format('Y-m-01') . ' 00:00:00', Carbon::today()->format('Y-m-t') . ' 23:59:59'])->count();
            $code = 'ASK' . Carbon::today()->format('Ym') . sprintf("%'03d", $count + 1);

            $req['photo'] = $file;
            $req['user_id'] = auth()->user()->id;
            $req['ap_id'] = $code;

            $ask_price = AskPrice::create($req);
    
            foreach(request('name') as $i => $name){
                AskPriceLits::create([
                    'ask_price_id' => $ask_price->id,
                    'name' => $name,
                    'amount' => request('amount')[$i],
                    'unit' => request('unit')[$i],
                ]);
            }
            
            foreach(request('supplier_id') as $i => $id){
                AskPriceSupplier::create([
                    'ask_price_id' => $ask_price->id,
                    'customer_id' => $id,
                ]);
            }
        });

        return redirect('/ask-price');
    }

    public function show(AskPrice $ap)
    {
        return view('ask-prices.show', compact('ap'));
    }

    public function print(AskPrice $ap, Customer $supplier)
    {
        return view('ask-prices.print', compact('ap', 'supplier'));
    }
}
