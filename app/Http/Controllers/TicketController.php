<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $tickets = Ticket::where('user_id', $user->id)->orderby('title')->latest()->paginate(2);
        $t = Ticket::find(1);
        return view('ticket.show', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        return view('ticket.create', compact('user'));
    }


    /**
     * @param Request $request
     * @return RedirectResponseAlias
     */
    public function store(Request $request): RedirectResponseAlias
    {
        // question about user_id //
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

        Ticket::create([
            'user_id' => $request->query('user'),
            'title' => $request->title,
            'subject' => $request->subject,
            'description' => $request->description,
            'attachment' => $file_name ?? null,
        ]);
        alert()->success('تیکت با موفقیت ایجاد گردید');
        return redirect()->back();


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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
