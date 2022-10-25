<?php

namespace App\Http\Controllers;

use App\Jobs\ResponseMailJob;
use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ResponseController extends Controller
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
        $this->authorize('viewAny', Response::class);
        $tickets = Ticket::with(['responses', 'subject'])->withTrashed()->latest()->paginate(5);
        return view('response.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Ticket $ticket)
    {
        $this->authorize('create', Response::class);
        $ticket = Ticket::with(['responses','subject'])->find($ticket->id);
        $ticketFirstResponse = $ticket->responses->chunk(2)->first();
        $ticketLastResponse = $ticket->responses->slice(2)->take(10);
        return view('response.create_response', compact('ticket','ticketFirstResponse','ticketLastResponse'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'text' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $response = Response::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'description' => trim($request->text),
            ]);
            $ticket->update([
                'status' => 2,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            alert()->error("خطا در ثبت پاسخ ");
            return redirect()->back();
        }
        $user = User::find($response->ticket->user_id);
        ResponseMailJob::dispatchSync($response, $user);
        alert()->success("پاسخ شما با موفقیت ثبت گردید");
        return redirect()->route('response.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Response $response)
    {

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
        $response = $ticket->responses->first();
        $this->authorize('update', $response);
        $ticket->update([
            'status' => key($request->status),
        ]);
        $status = implode($request->status);
        alert()->success("  وضعیت تیکت به $status تغییر پیدا کرد ")->addButton("ok", "ok");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
