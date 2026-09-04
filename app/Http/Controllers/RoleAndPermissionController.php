<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionController extends Controller
{
    public function get_role()
    {
        $search = request()->search;
        $users = User::with('roles.permissions')->when($search, function ($quary) use ($search) {
            $quary->where(function ($quary) use ($search) {
                $quary->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        })->when(!$search, function ($quary) {
            $quary->limit(10);
        })->get();
        return Inertia::render('RoleAndPermission/Index', ['users' => $users, 'permissions' => Permission::all(), 'roles' => Role::with('permissions')->get()]);
    }

    public function update_role(Request $request)
    {
        $user = User::find($request->user_id);
        $user->syncRoles($request->role_id);
        $role = $user->roles()->first();
        $role->syncPermissions($request->permissions);
        return response()->json(['user' => $user->load('roles.permissions')]);
    }

    public function create_role(Request $request)
    {
        $new_role = $request->validate([
            "role_name" => "required|unique:roles,name",
            "permissions" => "nullable|array",
            "permissions.*" => "integer|exists:permissions,id"
        ]);
        $role = Role::create([
            "name" => $new_role["role_name"]
        ]);
        $role->syncPermissions($new_role["permissions"]);
        return response()->json(['role' => $role->load('permissions')]);
    }

    public function delete_role($id)
    {
        $role = Role::find($id);
        $role->syncPermissions([]);
        $role->delete();
        return response()->json(['success' => true, 'message' => 'Success delete']);
    }

    public function update_role_permissions(Request $request)
    {
        $update_role_permissions =$request->validate([
           "role_id"=>"required",
           "permissions"=>"nullable||array" 
        ]);
        
        $role = Role::find($update_role_permissions['role_id']);
        $role->syncPermissions($update_role_permissions['permissions']);
        return response()->json(['success'=>true,"role"=>$role->load("permissions")]);
        
    }
}
