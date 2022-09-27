<?php

namespace App\Http\Controllers;

use App\Http\Consts\Ticketconsts;
use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function __construct()
    {
        if (!auth()->user()) {
            $this->middleware('auth');
        }
      $this->middleware('Checkadmin');

    }


    function index()
    {

        $users = User::orderby('created_at', 'DESC')->get();
        $subjects = Ticket::withTrashed()->where('parent_id', 0)->get();
        $tickets = Ticket::withTrashed()->where('parent_id', '!=', 0)->get();
        return view('admin.index', compact('tickets', 'subjects', 'users'));
    }

    function create_subject()
    {
        $user = auth()->user();
        return view('admin.create_subject', compact('user'));
    }

    function store_subject(Request $request, User $user)
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

    function edit_subject(Ticket $ticket)
    {
        $user = auth()->user();
        return view('admin.edit_subject', compact('user','ticket'));
    }

    function update_subject(Request $request, Ticket $ticket, $user)
    {
        $request->validate([
            'subject' => 'required',
        ]);

        $ticket->update([
            'subject' => $request->subject,
            'title' => $request->subject,
            'description' => $request->description === "" ? $request->subject : $request->description,
            'user_id'=>$user,
        ]);
        alert()->success('موضوع با موفقیت ویرایش گردید');
        return redirect()->route('admin.index');


    }

    function destroy_subject(Ticket $subject)
    {
        try {
            DB::beginTransaction();
            $subject->delete();
            foreach ($subject->child as $child) {
                $child->update([
                    'deleted_at' => Carbon::now(),
                ]);
                foreach ($child->responses_methode as $response) {
                    $response->update([
                        'deleted_at' => Carbon::now(),
                    ]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            alert()->warning('موضوع و تیکت ها حذف نگردید');
            return redirect()->route('admin.index');
        }

        alert()->success('موضوع حذف گردید');
        return redirect()->route('admin.index');
    }

}
