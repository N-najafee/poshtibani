<?php

namespace App\Http\Controllers;

use App\Http\Consts\Ticketconsts;
use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Exception;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use UxWeb\SweetAlert\SweetAlert;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        if (!auth()->user()) {
            $this->middleware('auth');
        }
    }


    public function index()
    {
        $user = auth()->user();
        $tickets = Ticket::withTrashed()-> where('parent_id', '!=', 0)->where('user_id', $user->id)->orderby('subject')->latest()->paginate(2);
        return view('ticket.show', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Ticket::where('parent_id', 0)->get();
        $user = auth()->user();
        return view('ticket.create', compact('user', 'subjects'));
    }


    /**
     * @param Request $request
     * @return RedirectResponseAlias
     */
    public function store(Request $request): RedirectResponseAlias
    {
        $request->validate([
            'title' => 'required',
            'subject_parent' => 'required',
            'description' => 'required',
            'attachment.*' => 'nullable|mimes:jpg,jpeg,png,svg,pdf,txt',
        ]);
        if ($request->has('attachment')) {
            $file_name = create_name($request->attachment->getclientoriginalname());
            $request->attachment->move(public_path(env('UPLOAD_FILE')), $file_name);
        }
        $subject=Ticket::find($request->subject_parent)->first()->subject;
        Ticket::create([
            'user_id' => $request->query('user'),
            'parent_id' => $request->subject_parent,
            'subject' =>  $subject,
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $file_name ?? null,
        ]);
        alert()->success('تیکت با موفقیت ایجاد گردید');
        return redirect()->route('ticket.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return view('admin.show_ticket', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        return view('admin.edit_ticket', compact('ticket'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'response'=>'required',
        ]);
        Response::find(key($request->response))->update([
            'description'=>implode($request->response),
            'user_id'=>auth()->user()->id,
            'updated_at'=>Carbon::now(),
        ]);
        alert()->success('پاسخ تیکت ویرایش گردید');
        return redirect()->route('admin.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        try {
            DB::beginTransaction();
            $ticket->delete();
            $ticket->update([
                'status'=> Ticketconsts::OPEN,
            ]);
            foreach ($ticket->responses_methode as $response) {
                $response->update([
                    'deleted_at' => Carbon::now()
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            alert()->warning('تیکت و پاسخ های آن به دلیل وجود خطاحذف نگردید ');
            return redirect()->route('admin.index');
        }

        alert()->success('تیکت و پاسخ های آن حذف گردید');
        return redirect()->route('admin.index');
    }
}
