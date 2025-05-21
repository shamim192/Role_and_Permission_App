<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
     public function dashboard()
    {
        if (!auth()->user()->can('view admin dashboard')) {
            abort(403);
        }

        return view('admin.dashboard');
    }

    public function users()
    {
        if (!auth()->user()->can('manage users')) {
            abort(403);
        }

        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        if (!auth()->user()->can('manage users')) {
            abort(403);
        }

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        if (!auth()->user()->can('manage users')) {
            abort(403);
        }

        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('admin.users')->with('success', 'User roles updated successfully');
    }

    public function roles()
    {
        if (!auth()->user()->can('manage roles')) {
            abort(403);
        }

        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request)
    {
        if (!auth()->user()->can('manage roles')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles')->with('success', 'Role created successfully');
    }

    public function updateRole(Request $request, Role $role)
    {
        if (!auth()->user()->can('manage roles')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles')->with('success', 'Role updated successfully');
    }

    public function deleteRole(Role $role)
    {
        if (!auth()->user()->can('manage roles')) {
            abort(403);
        }

        $role->delete();
        return redirect()->route('admin.roles')->with('success', 'Role deleted successfully');
    }

    public function permissions()
    {
        if (!auth()->user()->can('manage permissions')) {
            abort(403);
        }

        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function storePermission(Request $request)
    {
        if (!auth()->user()->can('manage permissions')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('admin.permissions')->with('success', 'Permission created successfully');
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        if (!auth()->user()->can('manage permissions')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('admin.permissions')->with('success', 'Permission updated successfully');
    }

    public function deletePermission(Permission $permission)
    {
        if (!auth()->user()->can('manage permissions')) {
            abort(403);
        }

        $permission->delete();
        return redirect()->route('admin.permissions')->with('success', 'Permission deleted successfully');
    }
}
