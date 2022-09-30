<?php

namespace App\Http\Controllers;

use App\Http\Consts\Ticketconsts;
use App\Http\Consts\Userconsts;
use App\Jobs\ticketMailjob;
use App\Mail\Ticketmail;
use App\Models\Response;
use App\Models\Subject;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

    }


    public function index()
    {
        $user = auth()->user();
        $tickets = Ticket::withTrashed()->where('user_id', $user->id)->orderby('created_at', 'DESC')->latest()->paginate(2);
        $this->authorize('viewAny', Ticket::class);
        return view('ticket.show', compact('tickets'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->authorize('create', Ticket::class);
        $subjects = Subject::all();
        return view('ticket.create', compact('subjects'));
    }


    /**
     * @param Request $request
     * @return RedirectResponseAlias
     */
    public function store(Request $request): RedirectResponseAlias
    {

        $request->validate([
            'title' => 'required',
            'subject' => 'required',
            'description' => 'required',
            'attachment.*' => 'nullable|mimes:jpg,jpeg,png,svg,pdf,txt',
        ]);
        if ($request->has('attachment')) {
            $file_name = create_name($request->attachment->getclientoriginalname());
            $request->attachment->move(public_path(env('UPLOAD_FILE')), $file_name);
        }
        $ticket = Ticket::create([
            'user_id' => auth()->user()->id,
            'subject_id' => $request->subject,
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $file_name ?? null,
        ]);
        $users = User::where('role', Userconsts::POSHTIBAN)->get();
        foreach ($users as $user) {
            TicketMailJob::dispatchSync($ticket, $user);
        }
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
        $this->authorize('view', $ticket);
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
        $this->authorize('update', $ticket);
        return view('admin.edit_ticket&response', compact('ticket'));

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
            'response.*' => 'required',
        ]);
        Response::find(key($request->response))->update([
            'description' => implode($request->response),
            'user_id' => auth()->user()->id,
            'updated_at' => Carbon::now(),
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
        $this->authorize('delete', $ticket);
        try {
            DB::beginTransaction();
            $ticket->delete();
            $ticket->update([
                'status' => Ticketconsts::OPEN,
            ]);
            foreach ($ticket->responses as $response) {
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
