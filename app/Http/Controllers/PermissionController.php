<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('note')->get();

        return view('admin.permission.index', compact('permissions'));
    }

    public function create()
    {
        $roles = Role::orderBy('note')->get();

        return view('admin.permission.create', compact('roles'));
    }

    public function store()
    {
        $permission = Permission::create(['name' => request('name'), 'note' => request('note')]);

        if (request('roles')) {
            foreach (request('roles') as $requestrole) {
                $role = Role::find($requestrole);
                $permission->assignRole($role);
            }
        }

        return redirect('/jb/admin/permissions');
    }

    public function edit(Permission $permission)
    {
        $roles = Role::orderBy('note')->get();

        return view('admin.permission.edit', compact('permission', 'roles'));
    }

    public function update(Permission $permission)
    {
        $permission->update(['name' => request('name'), 'note' => request('note')]);

        if ($permission->roles) {
            foreach ($permission->roles as $remove) {
                $permission->removeRole($remove);
            }
        }
        if (request('roles')) {
            foreach (request('roles') as $requestrole) {
                $role = Role::find($requestrole);
                $permission->assignRole($role);
            }
        }

        return redirect('/jb/admin/permissions');
    }
}
