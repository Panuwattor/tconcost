<?php

namespace App\Http\Controllers\Receive;

use App\Allocate;
use App\AllocateList;
use App\Customer;
use App\DepositPay;
use App\Events\ReceiveCountEvent;
use App\Events\ReceiveCountRREvent;
use App\Events\ReceiveCountRSEvent;
use App\Http\Controllers\Controller;
use App\PurchaseOrder;
use App\Project;
use App\PurchaseOrderList;
use App\Receive;
use App\ReceiveDueDate;
use App\ReceiveFile;
use App\ReceiveList;
use App\Retention;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReceiveController extends Controller
{
    public function index()
    {
        $receives = Receive::with('po', 'project', 'supplier', 'user', 'receive_lists')->where('status', 0)->orderBy('created_at', 'desc')->get();

        $pos_po = PurchaseOrder::where('status', 1)->where('po_type', 'PO')->get();
        $pos_ps = PurchaseOrder::where('status', 1)->where('po_type', 'PS')->get();
        $pos_sc = PurchaseOrder::where('status', 1)->where('po_type', 'SC')->get();

        return view('receives.index', compact('receives', 'pos_po', 'pos_ps', 'pos_sc'));
    }

    public function report()
    {

        $from = request('from') ? request('from') : Carbon::today()->format('Y-m-d');
        $to = request('to') ? request('to') : Carbon::today()->format('Y-m-d');
        $date_type = request('date_type') ? request('date_type') : 'date';
        $types = ['RR'];
        $status = request('status') ? request('status') : [0,1,2];
        $project_id = request('project_id') ? request('project_id') : 'all';
        $projects = Project::get();
        $pos_po = PurchaseOrder::where('status', 1)->where('po_type', 'PO')->get();

        if ($project_id != 'all' && $date_type == 'date') {
            $data = Receive::where('project_id', $project_id)
                ->whereIn('type', $types)
                ->whereIn('status', $status)
                ->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:59'])->orderBy('date', 'DESC')->get();
        } else if ($project_id != 'all' && $date_type == 'create_date') {
            $data = Receive::where('project_id', $project_id)
                ->whereIn('status', $status)
                ->whereIn('type', $types)
                ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->orderBy('created_at', 'DESC')->get();
        } else if ($project_id == 'all' && $types != '') {
            $data = Receive::whereIn('type', $types)
                ->whereIn('status', $status)
                ->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:59'])->orderBy('date', 'DESC')->get();
        } else if ($project_id == 'all' && $types == '') {
            $data = Receive::where('status', '!=', 15)->whereIn('status', $status)->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:59'])->orderBy('date', 'DESC')->get();
        }

        return view('receives.receive_report', compact('data', 'types', 'from', 'to', 'projects', 'date_type', 'project_id','status','pos_po'));
    }

    public function waiting_approvePAD()
    {
        $receives = Receive::with('po', 'project', 'supplier', 'user', 'receive_lists')->where('type','PAD')->orderBy('type')->where('status', 0)->get();

        return view('receives.waiting_approve', compact('receives'));
    }

    public function waiting_approveRR()
    {
        $receives = Receive::with('po', 'project', 'supplier', 'user', 'receive_lists')->where('type','RR')->orderBy('type')->where('status', 0)->get();

        return view('receives.waiting_approve', compact('receives'));
    }

    public function waiting_approveRS()
    {
        $receives = Receive::with('po', 'project', 'supplier', 'user', 'receive_lists')->where('type','RS')->orderBy('type')->where('status', 0)->get();

        return view('receives.waiting_approve', compact('receives'));
    }


    public function all_approve()
    {
        $receives = Receive::with('po', 'project', 'supplier', 'user', 'receive_lists')->where('status', 2)->get();

        return view('receives.receive_approve', compact('receives'));
    }

    public function all_reject()
    {
        $receives = Receive::with('po', 'project', 'supplier', 'user', 'receive_lists')->where('status', 3)->get();

        return view('receives.receive_reject', compact('receives'));
    }

    public function finish()
    {
        $receives = Receive::where('status', 1)->get();
        return view('receives.finish', compact('receives'));
    }

    public function all_close()
    {
        $receives = Receive::where('status', 15)->get();
        return view('receives.close', compact('receives'));
    }

    public function select_type()
    {
        return view('receives.select_type');
    }

    public function selected($receive)
    {
        $type = '';
        if ($receive == 'RR') {
            $type = 'PO';
        } else if ($receive == 'RS') {
            $type = 'PS';
        } else {
            $type = 'SC';
        }

        $pos = PurchaseOrder::with('purchaseOrderLists', 'user', 'project')->where('status', 1)->where('po_type', $type)->get();

        return view('receives.selected', compact('pos', 'receive'));
    }

    public function po_show(PurchaseOrder $po)
    {
        return view('receives.show', compact('po'));
    }

    public function receive(PurchaseOrder $po, $type)
    {
        $count = Receive::where('type', $type)->whereBetween('created_at', [Carbon::today()->format('Y-m-01') . ' 00:00:00', Carbon::today()->format('Y-m-t') . ' 23:59:59'])->count();
        $suppliers = Customer::whereIn('status', ['supplier','customer , supplier'])->get();

        $po_lists = $po->purchaseOrderLists;
        foreach($po_lists as $i => $po_list){
            $po_lists[$i]['list_notes'] = $po_list->listNotes;
        }

        return view('receives.receive', compact('po', 'suppliers', 'type', 'po_lists'));
    }

    public function receive_close(PurchaseOrder $po, $type)
    {

        $count = Receive::where('type', $type)->whereBetween('created_at', [Carbon::today()->format('Y-m-01') . ' 00:00:00', Carbon::today()->format('Y-m-t') . ' 23:59:59'])->count();
        $suppliers = Customer::whereIn('status', ['supplier','customer , supplier'])->get();

        return view('receives.receive_close', compact('po', 'suppliers', 'type'));
    }

    public function store(Request $request)
    {
        $res = DB::transaction(function () {
            $project = Project::find(request('receive')['project_id']);
            $count = Receive::where('project_id', $project->id)
                ->whereBetween('date', [Carbon::createFromFormat('Y-m-d', request('receive')['date'])->format('Y-m-01') . ' 00:00:00', Carbon::createFromFormat('Y-m-d', request('receive')['date'])->format('Y-m-t') . ' 23:59:59'])
                ->where('type', request('receive')['type'])->count();
            $receive_code = request('receive')['type'] . $project->code . Carbon::createFromFormat('Y-m-d', request('receive')['date'])->format('ym') . sprintf("%'03d", $count + 1);

            $_receive = request('receive');
            $_receive['sum_price'] = request('price')['sum_price'];
            $_receive['vat_amount'] = request('price')['vat_amount'];
            $_receive['sum'] = request('price')['sum'];
            $_receive['receive_code'] = $receive_code;
            $_receive['special_discount'] = request('price')['special_discount'];

            foreach (request('po_list') as $po_list) {
                $list = PurchaseOrderList::find($po_list['id']);
                if ($po_list['amount'] <= 0) {
                    return 'ยอดที่รับเป็น 0';
                }

                if ($list->received + $po_list['amount'] > $list->amount) {
                    return 'ยอดที่รับเกินจำนวน จริง';
                }

                if ($po_list['special_discount'] < 0 || !isset($po_list['special_discount']) || $po_list['special_discount'] + $list->receive_special_discount > $list->special_discount) {
                    return 'ส่วนลด พิเศษ ไม่ถูกต้อง';
                }

                if ($list->received + $po_list['amount'] == $list->amount && $po_list['special_discount'] + $list->receive_special_discount != $list->special_discount) {
                    return 'ส่วนลด พิเศษ ไม่ถูกใช้งาน';
                }
            }

            $receive = Receive::create($_receive);

            foreach (request('po_list') as $po_list) {
                $list = PurchaseOrderList::find($po_list['id']);

                ReceiveList::create([
                    'po_list_id' => $list->id,
                    'receive_id' => $receive->id,
                    'name' => $po_list['name'],
                    'amount' => $po_list['amount'],
                    'unit' => $po_list['unit'],
                    'unit_price' => $po_list['unit_price'],
                    'unit_discount' => $po_list['unit_discount'],
                    'price' => $po_list['price'],
                    'special_discount' => $po_list['special_discount'],
                    'fromAmount' => $list->received,
                ]);

                $list->received = $list->received + $po_list['amount'];
                $list->receive_special_discount = $list->receive_special_discount + $po_list['special_discount'];
                $list->update();
            }

            if (request('files')) {
                foreach (request('files') as $i => $file) {
                    $image = $file;
                    $data = explode(',', $image);
                    $current_timestamp = Carbon::now()->format('Ymdhis') . ($i + 1);
                    $filenametostore = 'uploads/' . $current_timestamp;
                    Storage::disk('spaces')->put($filenametostore, base64_decode($data[1]), 'public');

                    ReceiveFile::create([
                        'receive_id' => $receive->id,
                        'file' => $filenametostore,
                    ]);
                }
            }

            if (request('receive')['type'] == 'RS') {
                $duedate = ReceiveDueDate::create(request('duedate'));
                $receive->duedate_id = $duedate->id;
                $receive->update();
            }

            if (request('receive')['type'] == 'PAD') {
                Retention::create([
                    'receive_id' => $receive->id,
                    'project_id' => $receive->project_id,
                    'price' => request('retention'),
                    'user_id' => auth()->user()->id,
                ]);
            }

            $po = PurchaseOrder::find(request('po_list')[0]['purchase_order_id']);
            if (request('price')['special_discount'] > 0) {
                $po->receive_special_discount = $po->receive_special_discount + request('price')['special_discount'];
                $po->update();
            }

            $state = true;
            foreach ($po->purchaseOrderLists as $_po_list) {
                if ($_po_list->amount != $_po_list->received) {
                    $state = false;
                }
            }

            if ($state) {
                $po->status = 5;
                $po->update();
            }


            $po->project->logs()->create([
                'type' => 'PO',
                'type_id' => $po->id,
                'user_id' => auth()->user()->id,
                'note' => 'รับของ : ' . $receive_code
            ]);

            return 'success';
        });

        if ($res == 'success') {
            return 'success';
        } else {
            alert()->error('ผิดพลาด', $res);
            return 'fail';
        }
    }

    public function close(Request $request)
    {
        $res = DB::transaction(function () {
            $project = Project::find(request('receive')['project_id']);
            $count = Receive::where('project_id', $project->id)
                ->whereBetween('date', [Carbon::createFromFormat('Y-m-d', request('receive')['date'])->format('Y-m-01') . ' 00:00:00', Carbon::createFromFormat('Y-m-d', request('receive')['date'])->format('Y-m-t') . ' 23:59:59'])
                ->where('type', request('receive')['type'])->count();
            $receive_code = request('receive')['type'] . $project->code . Carbon::createFromFormat('Y-m-d', request('receive')['date'])->format('ym') . sprintf("%'03d", $count + 1);

            $_receive = request('receive');
            $_receive['sum_price'] = request('price')['sum_price'];
            $_receive['vat_amount'] = request('price')['vat_amount'];
            $_receive['sum'] = request('price')['sum'];
            $_receive['receive_code'] = $receive_code;
            $_receive['special_discount'] = request('price')['special_discount'];
            $_receive['status'] = 15;

            foreach (request('po_list') as $po_list) {
                $list = PurchaseOrderList::find($po_list['id']);
                if ($po_list['amount'] <= 0) {
                    return 'ยอดที่รับเป็น 0';
                }

                if ($list->received + $po_list['amount'] > $list->amount) {
                    return 'ยอดที่รับเกินจำนวน จริง';
                }

                if ($po_list['special_discount'] < 0 || !isset($po_list['special_discount']) || $po_list['special_discount'] + $list->receive_special_discount > $list->special_discount) {
                    return 'ส่วนลด พิเศษ ไม่ถูกต้อง';
                }

                if ($list->received + $po_list['amount'] == $list->amount && $po_list['special_discount'] + $list->receive_special_discount != $list->special_discount) {
                    return 'ส่วนลด พิเศษ ไม่ถูกใช้งาน';
                }
            }

            $receive = Receive::create($_receive);

            foreach (request('po_list') as $po_list) {
                $list = PurchaseOrderList::find($po_list['id']);

                ReceiveList::create([
                    'po_list_id' => $list->id,
                    'receive_id' => $receive->id,
                    'name' => $po_list['name'],
                    'amount' => $po_list['amount'],
                    'unit' => $po_list['unit'],
                    'unit_price' => $po_list['unit_price'],
                    'unit_discount' => $po_list['unit_discount'],
                    'price' => $po_list['price'],
                    'special_discount' => $po_list['special_discount'],
                    'fromAmount' => $list->received,
                ]);

                $list->received = $list->received + $po_list['amount'];
                $list->receive_special_discount = $list->receive_special_discount + $po_list['special_discount'];
                $list->update();

                // จัดสรรต้นทุน กลับคืน
                $allocate = Allocate::create([
                    'po_list_id' => $list->id
                ]);

                $amount = 0;
                if ($list->po->vat_type == 'นอก') {
                    $amount = $po_list['price'] * 0.07;
                } else {
                    $amount = $po_list['price'];
                }

                AllocateList::create([
                    'allocate_id' => $allocate->id,
                    'project_id' => $receive->project_id,
                    'project_cost_plan_list_id' => $list->allocate->allocate_list->first()->project_cost_plan_list_id,
                    'price' => -$amount,
                ]);

                foreach ($allocate->allocate_list as $allocate_list) {
                    $allocate_list->project_cost_plan_list->use_cost = $allocate_list->project_cost_plan_list->use_cost + $allocate_list->price;
                    $allocate_list->project_cost_plan_list->update();
                }
                // จัดสรรต้นทุน กลับคืน
            }

            if (request('files')) {
                foreach (request('files') as $i => $file) {
                    $image = $file;
                    $data = explode(',', $image);
                    $current_timestamp = Carbon::now()->format('Ymdhis') . ($i + 1);
                    $filenametostore = 'uploads/' . $current_timestamp;
                    Storage::disk('spaces')->put($filenametostore, base64_decode($data[1]), 'public');

                    ReceiveFile::create([
                        'receive_id' => $receive->id,
                        'file' => $filenametostore,
                    ]);
                }
            }

            if (request('receive')['type'] == 'RS') {
                $duedate = ReceiveDueDate::create(request('duedate'));
                $receive->duedate_id = $duedate->id;
                $receive->update();
            }

            if (request('receive')['type'] == 'PAD') {
                Retention::create([
                    'receive_id' => $receive->id,
                    'project_id' => $receive->project_id,
                    'price' => request('retention'),
                    'user_id' => auth()->user()->id,
                ]);
            }

            $po = PurchaseOrder::find(request('po_list')[0]['purchase_order_id']);
            if (request('price')['special_discount'] > 0) {
                $po->receive_special_discount = $po->receive_special_discount + request('price')['special_discount'];
                $po->update();
            }

            $state = true;
            foreach ($po->purchaseOrderLists as $_po_list) {
                if ($_po_list->amount != $_po_list->received) {
                    $state = false;
                }
            }

            if ($state) {
                $po->status = 5;
                $po->update();
            }

            $po->project->logs()->create([
                'type' => 'PO',
                'type_id' => $po->id,
                'user_id' => auth()->user()->id,
                'note' => 'ยกเลิก รับของ : ' . $receive_code
            ]);

            return 'success';
        });

        if ($res == 'success') {
            return 'success';
        } else {
            alert()->error('ผิดพลาด', $res);
            return 'fail';
        }
    }

    public function receive_show(Receive $receive)
    {
        return view('receives.receive_new_show', compact('receive'));
    }

    public function receive_waiting_approve(Receive $receive)
    {
        return view('receives.receive_waiting_approve', compact('receive'));
    }

    public function receive_delet()
    {
        DB::transaction(function () {
            $receive = Receive::find(request('receive_id'));

            if ($receive->status == 0) {
                foreach ($receive->receive_lists as $receive_list) {
                    $receive_list->po_list->received = $receive_list->po_list->received - $receive_list->amount;
                    $receive_list->po_list->update();

                    $receive_list->po_list->po->status = 2;
                    $receive_list->po_list->po->update();
                }

                if ($receive->receive_files->count() > 0) {
                    foreach ($receive->receive_files as $file) {
                        $file->delete();
                    }
                }

                if ($receive->duedate) {
                    $receive->duedate->delete();
                }

                if ($receive->retention) {
                    $receive->retention->delete();
                }

                foreach ($receive->receive_lists as $receive_list) {
                    $receive_list->delete();
                }

                $receive->delete();
            }
        });

        return back();
    }

    public function waiting_approve_store()
    {
        $receive = Receive::find(request('receive_id'));

        if ($receive->status != 0) {
            alert()->error('ไม่สำเร็จ', 'ไม่ใช่สถานะรออนุมัติ');
            
            return redirect('/receive/waiting/' . $receive->type);
        }

        DB::transaction(function () {
            $receive = Receive::find(request('receive_id'));
            $receive->status = 2;
            $receive->approveDate = Carbon::now();
            $receive->user_approve_id = auth()->user()->id;

            $receive->update();

            $receive->po->project->logs()->create([
                'type' => 'PO',
                'type_id' => $receive->po->id,
                'user_id' => auth()->user()->id,
                'note' => 'อนุมัติ รับของ : ' . $receive->receive_code
            ]);
        });

        alert()->success('สำเร็จ', 'อนุมัติเรียบร้อย');
        return redirect('/receive/approve');
    }

    public function receive_reject()
    {
        $receive = Receive::find(request('receive_id'));
        if ($receive->status != 0 && !auth()->user()->hasRole('developer')) {
            alert()->error('ไม่สำเร็จ', 'ไม่ใช่สถานะรออนุมัติ');
            return redirect('/receive/waiting');
        }

        DB::transaction(function () {
            $receive = Receive::find(request('receive_id'));
            $receive->po->receive_special_discount = $receive->po->receive_special_discount - $receive->special_discount;
            $receive->po->update();

            foreach ($receive->receive_lists as $receive_list) {
                $receive_list->po_list->receive_special_discount = $receive_list->po_list->receive_special_discount - $receive_list->special_discount;
                $receive_list->po_list->update();

                $receive_list->po_list->received = $receive_list->po_list->received - $receive_list->amount;
                $receive_list->po_list->update();

                $receive_list->po_list->po->status = 2;
                $receive_list->po_list->po->update();
            }

            $receive->status = 3;
            $receive->user_approve_id = auth()->user()->id;
            $receive->reject_note = request('reject_note');
            $receive->update();

            $receive->po->project->logs()->create([
                'type' => 'PO',
                'type_id' => $receive->po->id,
                'user_id' => auth()->user()->id,
                'note' => 'ไม่อนุมัติ รับของ : ' . $receive->receive_code . ' : ' . request('reject_note')
            ]);
        });

        alert()->success('สำเร็จ', 'ไม่อนุมัติเรียบร้อย');
        return redirect('/receive/reject');
    }

    public function print(Receive $receive)
    {
        if ($receive->type == 'PAD') {
            return view('receives.print_pad', compact('receive'));
        } else {
            return view('receives.print', compact('receive'));
        }
    }

    public function edit(Receive $receive)
    {
        $po = $receive->po;
        $type = $receive->type;
        $suppliers = Customer::whereIn('status', ['supplier','customer , supplier'])->get();

        $po_lists = $po->purchaseOrderLists;
        foreach($po_lists as $i => $po_list){
            $po_lists[$i]['list_notes'] = $po_list->listNotes;
        }

        return view('receives.receive_edit', compact('po', 'suppliers', 'type', 'receive', 'po_lists'));
    }
    
    public function approve_edit(Receive $receive)
    {
        $po = $receive->po;
        $type = $receive->type;
        $suppliers = Customer::whereIn('status', ['supplier','customer , supplier'])->get();

        return view('receives.receive_approve_edit', compact('po', 'suppliers', 'type', 'receive'));
    }

    public function update()
    {
        $res = DB::transaction(function () {
            $old_receive = Receive::find(request('receive_id'));
            if ($old_receive->status != 0) {
                return 'สถานะ ไม่สามารถแก้ไขได้';
            }

            foreach (request('po_list') as $po_list) {
                $state = true;
                $list = PurchaseOrderList::find($po_list['id']);

                foreach ($old_receive->receive_lists as $receive_list) {
                    if ($receive_list->po_list_id == $list->id) {
                        $state = false;
                        if ($po_list['amount'] <= 0) {
                            return 'ยอดที่รับเป็น 0';
                        }

                        if (($list->received - $receive_list->amount) + $po_list['amount'] > $list->amount) {
                            return 'ยอดที่รับเกินจำนวน จริง';
                        }

                        if ($po_list['special_discount'] < 0 || !isset($po_list['special_discount']) || $po_list['special_discount'] + ($list->receive_special_discount - $receive_list->special_discount) > $list->special_discount) {
                            return 'ส่วนลด พิเศษ ไม่ถูกต้อง';
                        }

                        if (($list->received - $receive_list->amount) + $po_list['amount'] == $list->amount && $po_list['special_discount'] + ($list->receive_special_discount - $receive_list->special_discount) != $list->special_discount) {
                            return 'ส่วนลด พิเศษ ไม่ถูกใช้งาน';
                        }
                    }
                }

                if ($state) {
                    if ($po_list['amount'] <= 0) {
                        return 'ยอดที่รับเป็น 0';
                    }

                    if ($list->received + $po_list['amount'] > $list->amount) {
                        return 'ยอดที่รับเกินจำนวน จริง';
                    }

                    if ($po_list['special_discount'] < 0 || !isset($po_list['special_discount']) || $po_list['special_discount'] + $list->receive_special_discount > $list->special_discount) {
                        return 'ส่วนลด พิเศษ ไม่ถูกต้อง';
                    }

                    if ($list->received + $po_list['amount'] == $list->amount && $po_list['special_discount'] + $list->receive_special_discount != $list->special_discount) {
                        return 'ส่วนลด พิเศษ ไม่ถูกใช้งาน';
                    }
                }
            }

            self::edit_reject($old_receive->id);

            $project = Project::find(request('receive')['project_id']);
            $_receive = request('receive');
            $_receive['sum_price'] = request('price')['sum_price'];
            $_receive['vat_amount'] = request('price')['vat_amount'];
            $_receive['sum'] = request('price')['sum'];
            $_receive['receive_code'] = $old_receive->receive_code;
            $_receive['special_discount'] = request('price')['special_discount'];
            $receive = Receive::create($_receive);

            foreach (request('po_list') as $po_list) {
                $list = PurchaseOrderList::find($po_list['id']);

                ReceiveList::create([
                    'po_list_id' => $list->id,
                    'receive_id' => $receive->id,
                    'name' => $po_list['name'],
                    'amount' => $po_list['amount'],
                    'unit' => $po_list['unit'],
                    'unit_price' => $po_list['unit_price'],
                    'unit_discount' => $po_list['unit_discount'],
                    'price' => $po_list['price'],
                    'special_discount' => $po_list['special_discount'],
                    'fromAmount' => $list->received,
                ]);

                $list->received = $list->received + $po_list['amount'];
                $list->receive_special_discount = $list->receive_special_discount + $po_list['special_discount'];
                $list->update();
            }

            if (request('files')) {
                foreach (request('files') as $i => $file) {
                    $image = $file;
                    $data = explode(',', $image);
                    $current_timestamp = Carbon::now()->format('Ymdhis') . ($i + 1);
                    $filenametostore = 'uploads/' . $current_timestamp;
                    Storage::disk('spaces')->put($filenametostore, base64_decode($data[1]), 'public');

                    ReceiveFile::create([
                        'receive_id' => $receive->id,
                        'file' => $filenametostore,
                    ]);
                }
            }

            if (request('current_files')) {
                foreach (request('current_files') as $current_file) {
                    ReceiveFile::create([
                        'receive_id' => $receive->id,
                        'file' => $current_file['file'],
                    ]);
                }
            }

            if (request('receive')['type'] == 'RS') {
                $duedate = ReceiveDueDate::create(request('duedate'));
                $receive->duedate_id = $duedate->id;
                $receive->update();
            }

            if (request('receive')['type'] == 'PAD') {
                Retention::create([
                    'receive_id' => $receive->id,
                    'project_id' => $receive->project_id,
                    'price' => request('retention'),
                    'user_id' => auth()->user()->id,
                ]);
            }

            $po = PurchaseOrder::find(request('po_list')[0]['purchase_order_id']);
            if (request('price')['special_discount'] > 0) {
                $po->receive_special_discount = $po->receive_special_discount + request('price')['special_discount'];
                $po->update();
            }

            $state = true;
            foreach ($po->purchaseOrderLists as $_po_list) {
                if ($_po_list->amount != $_po_list->received) {
                    $state = false;
                }
            }

            if ($state) {
                $po->status = 5;
                $po->update();
            }


            $po->project->logs()->create([
                'type' => 'PO',
                'type_id' => $po->id,
                'user_id' => auth()->user()->id,
                'note' => 'รับของ : ' . $old_receive->receive_code
            ]);

            return 'success';
        });

        if ($res == 'success') {
            return 'success';
        } else {
            alert()->error('ผิดพลาด', $res);
            return 'fail';
        }
    }
    
    public function approve_update()
    {
        $res = DB::transaction(function () {
            $old_receive = Receive::find(request('receive_id'));
            if ($old_receive->status != 2) {
                return 'สถานะ ไม่สามารถแก้ไขได้';
            }

            foreach($old_receive->invoice_ap_lists as $invoice_ap_list){
                if($invoice_ap_list->invoice_ap->status == 0 || $invoice_ap_list->invoice_ap->status == 1 || $invoice_ap_list->invoice_ap->status == 2){
                    return 'สถานะ ไม่สามารถแก้ไขได้';
                }
            }

            foreach (request('po_list') as $po_list) {
                $state = true;
                $list = PurchaseOrderList::find($po_list['id']);

                foreach ($old_receive->receive_lists as $receive_list) {
                    if ($receive_list->po_list_id == $list->id) {
                        $state = false;
                        if ($po_list['amount'] <= 0) {
                            return 'ยอดที่รับเป็น 0';
                        }

                        if (($list->received - $receive_list->amount) + $po_list['amount'] > $list->amount) {
                            return 'ยอดที่รับเกินจำนวน จริง';
                        }

                        if ($po_list['special_discount'] < 0 || !isset($po_list['special_discount']) || $po_list['special_discount'] + ($list->receive_special_discount - $receive_list->special_discount) > $list->special_discount) {
                            return 'ส่วนลด พิเศษ ไม่ถูกต้อง';
                        }

                        if (($list->received - $receive_list->amount) + $po_list['amount'] == $list->amount && $po_list['special_discount'] + ($list->receive_special_discount - $receive_list->special_discount) != $list->special_discount) {
                            return 'ส่วนลด พิเศษ ไม่ถูกใช้งาน';
                        }
                    }
                }

                if ($state) {
                    if ($po_list['amount'] <= 0) {
                        return 'ยอดที่รับเป็น 0';
                    }

                    if ($list->received + $po_list['amount'] > $list->amount) {
                        return 'ยอดที่รับเกินจำนวน จริง';
                    }

                    if ($po_list['special_discount'] < 0 || !isset($po_list['special_discount']) || $po_list['special_discount'] + $list->receive_special_discount > $list->special_discount) {
                        return 'ส่วนลด พิเศษ ไม่ถูกต้อง';
                    }

                    if ($list->received + $po_list['amount'] == $list->amount && $po_list['special_discount'] + $list->receive_special_discount != $list->special_discount) {
                        return 'ส่วนลด พิเศษ ไม่ถูกใช้งาน';
                    }
                }
            }

            self::edit_reject($old_receive->id);

            $project = Project::find(request('receive')['project_id']);
            $_receive = request('receive');
            $_receive['sum_price'] = request('price')['sum_price'];
            $_receive['vat_amount'] = request('price')['vat_amount'];
            $_receive['sum'] = request('price')['sum'];
            $_receive['receive_code'] = $old_receive->receive_code;
            $_receive['special_discount'] = request('price')['special_discount'];
            $_receive['note'] = $old_receive->note;
            $receive = Receive::create($_receive);

            foreach (request('po_list') as $po_list) {
                $list = PurchaseOrderList::find($po_list['id']);

                ReceiveList::create([
                    'po_list_id' => $list->id,
                    'receive_id' => $receive->id,
                    'name' => $po_list['name'],
                    'amount' => $po_list['amount'],
                    'unit' => $po_list['unit'],
                    'unit_price' => $po_list['unit_price'],
                    'unit_discount' => $po_list['unit_discount'],
                    'price' => $po_list['price'],
                    'special_discount' => $po_list['special_discount'],
                    'fromAmount' => $list->received,
                ]);

                $list->received = $list->received + $po_list['amount'];
                $list->receive_special_discount = $list->receive_special_discount + $po_list['special_discount'];
                $list->update();
            }

            if (request('files')) {
                foreach (request('files') as $i => $file) {
                    $image = $file;
                    $data = explode(',', $image);
                    $current_timestamp = Carbon::now()->format('Ymdhis') . ($i + 1);
                    $filenametostore = 'uploads/' . $current_timestamp;
                    Storage::disk('spaces')->put($filenametostore, base64_decode($data[1]), 'public');

                    ReceiveFile::create([
                        'receive_id' => $receive->id,
                        'file' => $filenametostore,
                    ]);
                }
            }

            if (request('current_files')) {
                foreach (request('current_files') as $current_file) {
                    ReceiveFile::create([
                        'receive_id' => $receive->id,
                        'file' => $current_file['file'],
                    ]);
                }
            }

            if (request('receive')['type'] == 'RS') {
                $duedate = ReceiveDueDate::create(request('duedate'));
                $receive->duedate_id = $duedate->id;
                $receive->update();
            }

            if (request('receive')['type'] == 'PAD') {
                Retention::create([
                    'receive_id' => $receive->id,
                    'project_id' => $receive->project_id,
                    'price' => request('retention'),
                    'user_id' => auth()->user()->id,
                ]);
            }

            $po = PurchaseOrder::find(request('po_list')[0]['purchase_order_id']);
            if (request('price')['special_discount'] > 0) {
                $po->receive_special_discount = $po->receive_special_discount + request('price')['special_discount'];
                $po->update();
            }

            $state = true;
            foreach ($po->purchaseOrderLists as $_po_list) {
                if ($_po_list->amount != $_po_list->received) {
                    $state = false;
                }
            }

            if ($state) {
                $po->status = 5;
                $po->update();
            }


            $po->project->logs()->create([
                'type' => 'PO',
                'type_id' => $po->id,
                'user_id' => auth()->user()->id,
                'note' => 'รับของ : ' . $old_receive->receive_code
            ]);

            return 'success';
        });

        if ($res == 'success') {
            return 'success';
        } else {
            alert()->error('ผิดพลาด', $res);
            return 'fail';
        }
    }

    public function receive_delete_file(ReceiveFile $receive_file)
    {
        $receive_file->delete();

        return back();
    }

    public function edit_reject($receive_id)
    {
        DB::transaction(function () use ($receive_id) {
            $receive = Receive::find($receive_id);
            $receive->po->receive_special_discount = $receive->po->receive_special_discount - $receive->special_discount;
            $receive->po->update();

            // if($receive->other_receives->count() > 0){
            //     foreach($receive->other_receives as $other_receive){
            //         foreach ($other_receive->other_receive_lists as $other_receive_list) {
            //             $other_receive_list->delete();
            //         }
    
            //         $other_receive->delete();
            //     }
            // }

            foreach ($receive->receive_lists as $receive_list) {
                $receive_list->po_list->receive_special_discount = $receive_list->po_list->receive_special_discount - $receive_list->special_discount;
                $receive_list->po_list->update();
            }

            foreach ($receive->receive_lists as $receive_list) {
                $receive_list->po_list->received = $receive_list->po_list->received - $receive_list->amount;
                $receive_list->po_list->update();

                $receive_list->po_list->po->status = 2;
                $receive_list->po_list->po->update();
            }

            $receive->status = 10;
            $receive->user_approve_id = auth()->user()->id;
            $receive->reject_note = 'แก้ไข receive';
            $receive->update();

            $receive->po->project->logs()->create([
                'type' => 'PO',
                'type_id' => $receive->po->id,
                'user_id' => auth()->user()->id,
                'note' => 'แก้ไข receive : ' . $receive->receive_code
            ]);
        });

        return redirect('/receive/waiting');
    }

    public function receive_countPAD()
    {
        event(new ReceiveCountEvent());
    }

    public function receive_countRR()
    {
        event(new ReceiveCountRREvent());
    }

    public function receive_countRS()
    {
        event(new ReceiveCountRSEvent());
    }
}
