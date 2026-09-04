<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search=$request->search;
        $role =$request->role;
        $users =User::with('employee.department')->when($search, function($quary) use ($search){
            $quary->where(function($query) use ($search){
                 $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            });
        })->when($role, function($quary) use ($role){
            $quary->role($role);
        })->get();
        return Inertia::render('Users/Index',['users'=>$users->load('roles')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return Inertia::render('Users/Create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        $user_data = $request->validated();
        $roles = $user_data['roles'];

        unset($user_data['roles']);

        $user_data['password'] = Hash::make($user_data['password']);
        $user = User::create($user_data);
        $user->assignRole($roles);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        $user->load(['roles']);
        return Inertia::render('Users/View', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $user =User::find($id);
    $user->load(['roles']);
    return Inertia::render('Users/Edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $update_user = $request->validated();
        $roles = $update_user['roles'];
        if (empty($update_user['password'])) {
            unset($update_user['password']);
        } else {
            $update_user['password'] = Hash::make($update_user['password']);
        }
        unset($update_user['roles']);
        $user->update($update_user);
        $user->syncRoles($roles);
        return redirect()->back()->with(['success' => 'Success update']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $user =User::find($id);
        $user->delete();
        return redirect()->back()->with('Success','Success Delete');
    }
}
