<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function name(User $user)
    {
        if (request('name')) {
            $user->name = request('name');
            $user->update();
        }

        return back();
    }

    public function photo(User $user)
    {
        if (request('photo')) {
            Storage::disk('public')->delete($user->photo);
            $file = request('photo')->store('user', 'public');
        } else {
            $file = $user->photo;
        }

        $user->photo = $file;
        $user->update();

        return back();
    }

    public function updatePassword(User $user)
    {
        if (Hash::check(request('old_password'), $user->password)) {
            if (request('new_password') == request('confirm_password')) {
                $user->password = Hash::make(request('new_password'));
                $user->update();

                alert()->success('แก้ไข', 'สำเร็จ');
            } else {
                alert()->error('รหัสผ่านไม่ตรงกัน', 'ไม่สำเร็จ');
            }
        } else {
            alert()->error('รหัสผ่านเดิมไม่ถูกต้อง', 'ไม่สำเร็จ');
        }

        return back();
    }

    public function lists()
    {
        $users = User::get();
        $permissions = Permission::orderBy('note')->get();
        $roles = Role::orderBy('note')->get();

        return view('users.lists', compact('users', 'permissions', 'roles'));
    }

    public function update(User $user)
    {
        if (request('photo')) {
            Storage::disk('public')->delete($user->photo);
            $file = request('photo')->store('user', 'public');
        } else {
            $file = $user->photo;
        }

        if (request('signature')) {
            Storage::disk('public')->delete($user->signature);
            $signature = request('signature')->store('user', 'public');
        } else {
            $signature = $user->signature;
        }

        if (request('password')) {
            $password = Hash::make(request('password'));
        } else {
            $password = $user->password;
        }

        $user->update(array_merge(request()->all(), ['password' => $password, 'photo' => $file, 'signature' => $signature]));

        if ($user->roles) {
            foreach ($user->roles as $removerole) {
                $user->removeRole($removerole);
            }
        }
        if ($user->permissions) {
            foreach ($user->permissions as $removeperm) {
                $user->revokePermissionTo($removeperm);
            }
        }

        if (request('roles')) {
            foreach (request('roles') as $requestrole) {
                $role = Role::find($requestrole);
                $user->assignRole($role);
            }
        }

        if (request('permissions')) {
            foreach (request('permissions') as $id) {
                $permission = Permission::find($id);
                $user->givePermissionTo($permission);
            }
        }

        alert()->success('แก้ไข', 'สำเร็จ');

        return back();
    }

    public function store()
    {

        if (request('photo')) {
            $file = request('photo')->store('user', 'public');
        } else {
            $file = Null;
        }

        if (request('signature')) {
            $signature = request('signature')->store('user', 'public');
        } else {
            $signature = Null;
        }

        $password = Hash::make(request('password'));

        $user = User::create(array_merge(request()->all(), ['password' => $password, 'photo' => $file, 'signature' => $signature]));

        if (request('roles')) {
            foreach (request('roles') as $requestrole) {
                $role = Role::find($requestrole);
                $user->assignRole($role);
            }
        }

        if (request('permissions')) {
            foreach (request('permissions') as $id) {
                $permission = Permission::find($id);
                $user->givePermissionTo($permission);
            }
        }
        return back();
    }

    public function show()
    {
      $today = Carbon::today();
      $from = request('from') ?: $today->format('Y-m-d');
      $to = request('to') ?: $today->format('Y-m-d');
  
        $gets = file_get_contents('https://mytcg.net/get/users');
        $objs = json_decode($gets);
        $user = auth()->user();
         if($user->match){
          $match_get = file_get_contents('https://mytcg.net/get/user/find/' . $user->match->match_id);
          $matchget = json_decode($match_get);
         }else{
          $matchget = Null;
         }
        return view('users.show', compact('user','objs','matchget','from','to'));
    }

    public function auth_update(User $user)
    {
        if(request('password')){
          $password = Hash::make(request('password'));
        }else{
          $password = $user->password;
        }
  
        if (request('photo')) {
            Storage::disk('public')->delete($user->photo);
            $photo = request('photo')->store('user', 'public');
        } else {
            $photo = $user->photo;
        }
  
        $user->update(array_merge(request()->all(),['password'=>$password,'photo'=>$photo]));
  
        alert()->success('แก้ไข', 'สำเร็จ')->persistent('ตกลง');
        return back();
    }
}
