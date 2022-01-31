<?php

namespace App\Http\Controllers\Wht;

use App\Branch;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Wht;
use App\WhtGroup;
use App\WhtList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Collection;

class WhtController extends Controller
{
    public function report()
    {
        $customers = Customer::get();
        $customer_select = request('customer_select') ? request('customer_select') : 'all';
        $branchs = Branch::get();
        $branch_select = request('branch_select') ? request('branch_select') : '';
        
        if($branch_select){
            $branch = Branch::find($branch_select);
        }else{
            $branch = Branch::first();
        }

        $from = request('from') ? request('from') : Carbon::today()->format('Y-m-d');
        $to = request('to') ? request('to') : Carbon::today()->format('Y-m-d');

        $types = [];
        $data = array();

        if (request('types') && $customer_select != 'all') {
            $types = request('types');
            $whts = wht::with('supplier', 'wht_lists')->whereIn('type',$types)->where('supplier_id', $customer_select)->whereBetween('date', [$from , $to])->get();
        }else{
            if($customer_select != 'all'){
                $whts = wht::with('supplier', 'wht_lists')->where('supplier_id', $customer_select)->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
            }else{
                $whts = wht::with('supplier', 'wht_lists')->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
            }
        }     

        foreach($whts as $wht){
            array_push($data, $wht);
        }

        Collection::macro('toUpper', function () {
            return $this->map(function ($value) {
                return $value;
            });
        });
        
        $collection = collect($data);
        
        $data = $collection->toUpper();

        return view('wht.wht_report',compact('from','to','data','types', 'customers', 'customer_select', 'branchs', 'branch_select', 'branch'));

    }
    
    public function print_report()
    {
        $customers = Customer::get();
        $customer_select = request('customer_select') ? request('customer_select') : 'all';
        $branch_select = request('branch_select') ? request('branch_select') : '';
        
        $branch = auth()->user()->branch;

        $from = request('from') ? request('from') : Carbon::today()->format('Y-m-d');
        $to = request('to') ? request('to') : Carbon::today()->format('Y-m-d');

        $types = [];
        $data = array();

        if (request('types') && $customer_select != 'all') {
            $types = request('types');
            $whts = wht::with('supplier', 'wht_lists')->whereIn('type',$types)->where('supplier_id', $customer_select)->whereBetween('date', [$from , $to])->get();
        }else{
            if($customer_select != 'all'){
                $whts = wht::with('supplier', 'wht_lists')->where('supplier_id', $customer_select)->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
            }else{
                $whts = wht::with('supplier', 'wht_lists')->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
            }
        }     

        foreach($whts as $wht){
            array_push($data, $wht);
        }

        Collection::macro('toUpper', function () {
            return $this->map(function ($value) {
                return $value;
            });
        });
        
        $collection = collect($data);
        
        $data = $collection->toUpper();

        return view('wht.print_report',compact('from','to','data','types', 'customers', 'customer_select', 'branch_select', 'branch'));
    }
    
    public function index()
    {
        $whts = Wht::whereIn('status', [0, 1])->where('branch_id',auth()->user()->branch_id)->get();
        return view('wht.index', compact('whts'));
    }
    
    public function finish()
    {
        $whts = Wht::where('status', 2)->where('branch_id',auth()->user()->branch_id)->get();
        return view('wht.finish_index', compact('whts'));
    }
    
    public function reject()
    {
        $whts = Wht::whereIn('status', [3,10])->where('branch_id',auth()->user()->branch_id)->get();

        return view('wht.reject_index', compact('whts'));
    }

    public function create()
    {
        $suplliers = Customer::where('branch_id',auth()->user()->branch_id)->get();
        $wht_groups = WhtGroup::all();

        return view('wht.create', compact('suplliers' , 'wht_groups'));
    }

    public function store()
    {
        $res = DB::transaction(function () {
            $count = Wht::where('branch_id',auth()->user()->branch_id)->whereBetween('date', [Carbon::createFromFormat('Y-m-d', request('date'))->format('Y-m-01') . ' 00:00:00', Carbon::createFromFormat('Y-m-d', request('date'))->format('Y-m-t') . ' 23:59:59'])->count();
            $code = 'WT' . Carbon::createFromFormat('Y-m-d', request('date'))->format('Ym') . sprintf("%'03d", $count + 1);

            $request = request()->all();
            $request['user_id'] = auth()->user()->id;
            $request['code'] = $code;
            $request['branch_id'] = auth()->user()->branch_id;
            
            if (!request('wht_type')) {
                alert()->error('ไม่สำเร็จ', 'ผิดพลาด');
                return "ผิดพลาด";
            }

            $wht = Wht::create($request);

            foreach (request('wht_type') as $i => $wht_type) {
                WhtList::create([
                    'wht_id' => $wht->id,
                    'wht_group_id' => $wht_type,
                    'article' => request('article')[$i],
                    'note' => request('wht_note')[$i],
                    'amount' => request('amount')[$i],
                    'rate' => request('rate')[$i],
                    'wht_tax' => request('wht_tax')[$i]
                ]);
            }

            return 'success';
        });

        if ($res != 'ผิดพลาด') {
            return redirect('/wht');
        } else {
            return back();
        }
    }
    
    public function edit_store(Wht $wht)
    {
        $res = DB::transaction(function () use ($wht) {
            if($wht->status != 0 && !auth()->user()->hasRole('developer')){
                alert()->error('ไม่สำเร็จ', 'ผิดพลาด สถานะ');
                return "ผิดพลาด";
            }

            if (!request('wht_type')) {
                alert()->error('ไม่สำเร็จ', 'ผิดพลาด');
                return "ผิดพลาด";
            }

            $wht->update(request()->all());
            foreach($wht->wht_lists as $wht_list){
                $wht_list->delete();
            }

            foreach (request('wht_type') as $i => $wht_type) {
                WhtList::create([
                    'wht_id' => $wht->id,
                    'wht_group_id' => $wht_type,
                    'article' => request('article')[$i],
                    'note' => request('wht_note')[$i],
                    'amount' => request('amount')[$i],
                    'rate' => request('rate')[$i],
                    'wht_tax' => request('wht_tax')[$i]
                ]);
            }

            return 'success';
        });

        if ($res != 'ผิดพลาด') {
            return redirect('/wht/show/' . $wht->id);
        } else {
            return back();
        }
    }

    public function show(Wht $wht)
    {   
        if($wht->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        return view('wht.show', compact('wht'));
    }

    public function wht_group()
    {   
        $wht_groups = WhtGroup::all();

        return view('wht.group', compact('wht_groups'));
    }

    public function wht_group_store()
    {   
        DB::transaction(function(){
            WhtGroup::create(request()->all());
        }); 

        alert()->success('สำเร็จ','บันทึกเรียบร้อย');
        return redirect('/wht/group');
    }

    public function update()
    {
        DB::transaction(function(){
            $wht_group = WhtGroup::find(request('wht_group_id'));
            $wht_group->update(request()->all());
        });

        alert()->success('สำเร็จ','Update เรียบร้อย');
        return redirect('/wht/group');
    }

    public function print(Wht $wht)
    {   
        if($wht->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        $branch = request('brach_id') ? Branch::find(request('brach_id')) : null;

        if($branch && $branch->id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด','ไม่มีสิทธิ์เข้าถึง');
            return redirect('/wht/group');
        }
        return view('wht.print', compact('wht', 'branch'));
    }

    public function wht()
    {
        $whts = Wht::where('status', 2)->get();
        return view('wht.select', compact('whts'));
    }

    public function payment_finish()
    {
        $whts = Wht::where('status', 4)->get();

        return view('wht.payment_finish_index', compact('whts'));
    }

    public function edit(Wht $wht)
    {
        if($wht->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }
        $suplliers = Customer::where('branch_id',auth()->user()->branch_id)->get();
        $wht_groups = WhtGroup::all();

        return view('wht.edit', compact('suplliers', 'wht_groups', 'wht'));
    }

    public function delete(Wht $wht)
    {
        if($wht->status > 0){
            alert()->error('ผิดพลาด', 'ไม่สามารถลบได้');
            return back();
        }

        DB::beginTransaction();

        $wht->status = 10;
        $wht->update();

        DB::commit();

        return redirect('/wht');
    }
}
