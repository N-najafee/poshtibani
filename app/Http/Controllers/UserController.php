<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {

        return redirect()->route('admin.index');
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('admin.create_user');

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|current_password:web',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => hash::make($request->password,),
            'is_active' => $request->is_active,
            'role' => $request->role,
        ]);
        alert()->success(' کاربر ایجاد گردید.');
        return redirect()->route('admin.index');
    }


    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('admin.edit_user', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => ($request->is_active),
            'role' => $request->role,
        ]);

        alert()->success(' کاربر ویرایش گردید.');
        return redirect()->route('admin.index');
    }

}
