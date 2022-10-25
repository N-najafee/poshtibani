<?php

namespace App\Http\Controllers;

use App\Http\Consts\Ticketconsts;
use App\Http\Consts\Userconsts;
use App\Jobs\TicketMailJob;
use App\Models\Response;
use App\Models\Subject;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Exception;
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

    }

    public function index()
    {
        $this->authorize('viewAny', Ticket::class);
        $user = Auth::user();
        $tickets = Ticket::withCount('responses')->with('subject')->without('responses')->withTrashed()->latest()->paginate(2);
        return view('ticket.index', compact('tickets'));
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
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'subject' => 'required',
            'description' => 'required',
            'attachment.*' => 'nullable|mimes:jpg,jpeg,png,svg,pdf,txt',
        ]);
        if ($request->has('attachment')) {
            $file_name = CreateFileName($request->attachment->getclientoriginalname());
            $request->attachment->move(public_path(env('UPLOAD_FILE')), $file_name);
        }
        $ticket = Ticket::create([
            'user_id' => Auth::id(),
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
        $ticket = Ticket::with(['responses','subject'])->find($ticket->id);
        $ticketFirstResponse = $ticket->responses->chunk(2)->first();
        $ticketLastResponse = $ticket->responses->slice(2)->take(10);
        return view('ticket.show', compact('ticket', 'ticketFirstResponse', 'ticketLastResponse'));
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
        $ticket = Ticket::with(['responses', 'subject'])->find($ticket->id);
        $ticketFirstResponse = $ticket->responses->chunk(2)->first();
        $ticketLastResponse = $ticket->responses->slice(2)->take(10);
        return view('admin.edit_ticket&response', compact('ticket', 'ticketFirstResponse', 'ticketLastResponse'));
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
            'user_id' => Auth::id(),
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

    public function get_data(Ticket $ticket)
    {
        $ticket = Ticket::with('responses')->find($ticket->id);
        $users = User::all();
        $ticketLastResponse = $ticket->responses->slice(2)->take(10);
        return (['ticketLastResponse' => $ticketLastResponse, 'users' => $users]);
    }
}
