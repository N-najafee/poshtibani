<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {
        if(!auth()->user()){
            $this->middleware('auth');
        }
        $this->middleware('Checkadmin');
    }

    function create_user()
    {

        return view('admin.create_user');

    }

    function store_user(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8',
            'confirm_password'=>'required|current_password:web',
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'is_active'=>$request->is_active,
            'role'=>$request->role,
        ]);
        alert()->success(' کاربر ایجاد گردید.');
        return redirect()->route('admin.index');
//        dd($request->all());


    }

    function edit_user(User $user)
    {

        return view('admin.edit_user', compact('user'));
    }

    function update_user(Request $request, User $uuser)
    {
        if(Gate::allows('update', $uuser)) {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $uuser->id,
            ]);
            $uuser->update([
                'name' => $request->name,
                'email' => $request->email,
                'is_active' => ($request->is_active),
                'role' => $request->role,
            ]);

            alert()->success(' کاربر ویرایش گردید.');
            return redirect()->route('admin.index');
        }else{

            alert()->error('ویرایش توسط مدیر انجام می گردد.');
            return redirect()->route('admin.index');
        }
    }

}
