<?php

namespace App\Http\Controllers\AskPrice;

use App\AskPrice;
use App\AskPriceLits;
use App\AskPriceSupplier;
use App\Customer;
use App\Project;
use App\User;
use App\Http\Controllers\Controller;
use App\UserToBranch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AskPriceController extends Controller
{
    public function index()
    {
        $ask_prices = AskPrice::orderBy('created_at','DESC')->where('branch_id',auth()->user()->branch_id)->get();
        return view('ask-prices.index', compact('ask_prices'));
    }
    
    public function expired()
    {
        $ask_prices = AskPrice::whereDate('finish_date', '<', Carbon::today()->format('Y-m-d'))->where('branch_id',auth()->user()->branch_id)->get();
        return view('ask-prices.expired', compact('ask_prices'));
    }
    
    public function create()
    {
        $projects = Project::where('status', '!=', 0)->where('type', 0)->where('branch_id',auth()->user()->branch_id)->get();
        $main_users = UserToBranch::where('branch_id',auth()->user()->branch_id)->get();
        $suppliers = Customer::whereIn('status',[ 'supplier','customer , supplier','customer'])->where('branch_id',auth()->user()->branch_id)->get();

        return view('ask-prices.create', compact('projects', 'main_users', 'suppliers'));
    }

    public function store()
    {
        DB::transaction(function(){
            $file = null;
            $req = request()->all();
    

            if (request('photo')) {
                $file = Storage::disk('spaces')->putFile('tconcost/project/'.request('project_id'), request('photo'), 'public');
            } else {
                $file = Null;
            }
    
            $count = AskPrice::whereBetween('created_at', [Carbon::today()->format('Y-m-01') . ' 00:00:00', Carbon::today()->format('Y-m-t') . ' 23:59:59'])->where('branch_id',auth()->user()->branch_id)->count();
            $code = 'ASK' . Carbon::today()->format('Ym') . sprintf("%'03d", $count + 1);

            $req['photo'] = $file;
            $req['user_id'] = auth()->user()->id;
            $req['ap_id'] = $code;
            $req['branch_id'] = auth()->user()->branch_id;

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
        if($ap->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        return view('ask-prices.show', compact('ap'));
    }

    public function print(AskPrice $ap, Customer $supplier)
    {
        if($ap->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        return view('ask-prices.print', compact('ap', 'supplier'));
    }
}
