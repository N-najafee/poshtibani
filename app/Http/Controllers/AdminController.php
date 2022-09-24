<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function __construct()
    {
        if (!auth()->user()) {
            $this->middleware('auth');
        }
    }


    function index()
    {
        if (auth()->user()->getraworiginal('role') === self::POSHTIBAN) {
            return redirect()->route('poshtiban.index');
        } elseif (auth()->user()->getraworiginal('role') === self::USER) {
            return redirect()->route('admin.index');
        }
        $users = User::all();
        $subjects = Ticket::where('parent_id', 0)->latest()->paginate(10);
        $tickets = Ticket::where('parent_id', '!=', 0)->latest()->paginate(4);
        return view('admin.index', compact('tickets', 'subjects', 'users'));
    }

    function create_subject(Ticket $subject)
    {
        $user = auth()->user();
        return view('admin.subject', compact('user', 'subject'));
    }

    function store(Request $request, User $user)
    {
        $request->validate([
            'name_subject' => 'required|unique:tickets,subject',
        ]);

        Ticket::create([
            'subject' => $request->name_subject,
            'title' => $request->name_subject,
            'description' => trim($request->description),
            'parent_id' => 0,
            'user_id' => $user->id,
            'status' => 0,
        ]);
        alert()->success('موضوع با موفقیت ایجاد گردید');
        return redirect()->route('admin.index');

    }

    function update_subject(Request $request, Ticket $ticket, User $user)
    {
        $request->validate([
            'subject' => 'required',
        ]);

        $ticket->update([
            'subject' => $request->subject,
            'title' => $request->subject,
            'description' => $request->description,
        ]);
        alert()->success('موضوع با موفقیت ویرایش گردید');
        return redirect()->route('admin.index');


    }

    function destroy_subject(Ticket $subject)
    {
        $subject->delete();
        alert()->success('موضوع حذف گردید');
        return redirect()->route('admin.index');
    }

    function edit(User $user)
    {

        return view('admin.edit_user', compact('user'));
    }

    function update(Request $request, User $uuser)
    {
//        dd($request->is_active);
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

    function show(Ticket $ticket){

        return view('admin.show',compact('ticket'));
    }



}
