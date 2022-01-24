<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('note')->get();

        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('note')->get();

        return view('admin.role.create', compact('permissions'));
    }

    public function store()
    {
        $role = Role::create(['name' => request('name'), 'note' => request('note')]);

        if (request('permissions')) {
            foreach (request('permissions') as $id) {
                $permission = Permission::find($id);
                $role->givePermissionTo($permission);
            }
        }

        return redirect('/jb/admin/roles');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('note')->get();

        return view('admin.role.edit', compact('permissions', 'role'));
    }

    public function update(Role $role)
    {
        $role->update(['name' => request('name'), 'note' => request('note')]);

        if ($role->permissions) {
            foreach ($role->permissions as $remove) {
                $role->revokePermissionTo($remove);
            }
        }
        if (request('permissions')) {
            foreach (request('permissions') as $id) {
                $permission = Permission::find($id);
                $role->givePermissionTo($permission);
            }
        }

        return redirect('/jb/admin/roles');
    }
}
