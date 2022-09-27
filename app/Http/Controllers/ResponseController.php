<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResponseController extends Controller
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
        $tickets = Ticket::withTrashed()->where('parent_id', '!=', 0)->latest()->paginate(5);
        return view('poshtiban.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Ticket $ticket)
    {
        return view('poshtiban.response', compact('ticket'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Ticket $ticket)
    {
        $request->validate([
            'text' => 'required',
        ]);
        try {
            DB::beginTransaction();
            Response::create([
                'ticket_id' => $ticket->id,
                'user_id' => auth()->user()->id,
                'description' => trim($request->text),
            ]);
            $ticket->update([
                'status' => $ticket->getRawOriginal('status') ? 2 : 2,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            alert()->error("خطا در ثبت پاسخ ");
            return redirect()->back();
        }
        alert()->success("پاسخ شما با موفقیت ثبت گردید");
        return redirect()->route('poshtiban.response.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $ticket_status=$ticket->getraworiginal('status');
        if($ticket_status !== key($request->status) ){
            $ticket->update([
                'status'=> key($request->status) ,
            ]);
        }
        $status=implode($request->status);
        alert()->success("  وضعیت تیکت به $status تغییر پیدا کرد ")->addButton("ok","ok");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
