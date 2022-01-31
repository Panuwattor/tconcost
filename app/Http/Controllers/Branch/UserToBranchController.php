<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Branch;
use App\User;
use App\UserToBranch;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserToBranchController extends Controller
{
    public function index()
    {
        if(!auth()->user()){
            return redirect('login');
        }

        $to_branchs = UserToBranch::where('user_id',auth()->user()->id)->get();
        return view('branchs.user.index', compact('to_branchs'));
    }

    public function store()
    {
        $branch = Branch::create(array_merge(request()->all()));
        if (UserToBranch::where('user_id', auth()->user()->id)->where('branch_id', $branch->id)->exists()) {
            $branch->update([
                'status' => 0
            ]);
            alert()->error('ผิดพลาด', 'บันทึกไปแล้ว');
            return back();
        }
        DB::transaction(function () use ($branch) {

            if (request('logo')) {
                $logo = Storage::disk('spaces')->putFile('tconcost/branch/' . $branch->id, request('logo'), 'public');
                $branch->update([
                    'logo' => $logo
                ]);
            }
            UserToBranch::create([
                'user_id' => auth()->user()->id,
                'branch_id' => $branch->id,
                'status' => 1
            ]);
        });
        alert()->success('สำเร็จ', 'ทำรายการเรียบร้อย');
        return back();
    }

    public function update(Branch $branch)
    {
        if (request('logo')) {
            Storage::disk('spaces')->delete($branch->logo);
            $logo = Storage::disk('spaces')->putFile('tconcost/branch/' . $branch->id, request('logo'), 'public');
        } else {
            $logo = $branch->logo;
        }
        $branch->update(array_merge(request()->all(), ['logo' => $logo]));

        return back();
    }

    public function register_user()
    {
        if (User::where('email', request('email'))->exists()) {
            alert()->error('ผิดพลาด', 'email นี้ถูกใช้งานแล้ว');
            return back();
        }
        $password = Hash::make(request('password'));

        $user = User::create(array_merge(request()->all()));

        if (request('photo')) {
            $file = Storage::disk('spaces')->putFile('tconcost/user/' . $user->id, request('photo'), 'public');
        } else {
            $file = Null;
        }

        $user->update([
            'password' => $password,
            'photo' => $file,
        ]);

        if (request('to_branchs')) {
            foreach (request('to_branchs') as $id) {
                UserToBranch::create([
                    'user_id' => $user->id,
                    'branch_id' => $id,
                    'status' => 1
                ]);
            }
        }
        return back();
    }

    public function merge_user(Branch $branch)
    {
        $user = User::where('email',request('email'))->first();
        if(!$user){
            alert()->error('ผิดพลาด', 'ไม่พบ Email');
            return back();
        }

        if (UserToBranch::where('user_id', $user->id)->where('branch_id', $branch->id)->exists()) {
            alert()->error('ผิดพลาด', 'มี Email อยู่แล้ว');
            return back();
        }

        UserToBranch::create([
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'status' => request('status')
        ]);

        alert()->success('สำเร็จ', 'ทำรายการเรียบร้อย');
        return back();
    }

    public function manage(UserToBranch $usertobranch)
    {

        if(request('type') == 1){
            if($usertobranch->user->branch_id == $usertobranch->branch_id){
                $usertobranch->user->update([
                    'branch_id'=>Null
                ]);
            }
            $usertobranch->delete();
        }
        if(request('type') == 2){
            $usertobranch->update([
                'status'=>request('status')
            ]);
        }
        alert()->success('สำเร็จ', 'ทำรายการเรียบร้อย');
        return back();
    }

    public function checkout(UserToBranch $to_branch)
    {
        if(!auth()->user()){
            return redirect('login');
        }
        
        if($to_branch->user_id == auth()->user()->id){

            if($to_branch->branch_id == auth()->user()->branch_id){
                return back();
            }

            auth()->user()->update([
                'branch_id'=>$to_branch->branch_id
            ]);
            alert()->success('สำเร็จ', 'เปลี่ยนบริษัทเรียบร้อย');
            return back();
        }
       
        alert()->error('ผิดพลาด', 'ไม่สามารถทำรายการได้');
        return back();
    }

    
}
