<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if(!auth()->user()){
            $this->middleware('auth');
        }
    }


    public function index()
    {
//        $ti=Ticket::find(3);
//        foreach ($ti->responses_methode->slice(2) as $t){
//            echo $t->description . "<br>";
//        }
        $user = auth()->user();
        $tickets = Ticket::where('parent_id','!=',0)->where('user_id',$user->id)->orderby('title')->latest()->paginate(2);
        return view('ticket.show', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects=Ticket::where('parent_id',0)->get();
        $user = auth()->user();
        return view('ticket.create', compact('user','subjects'));
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
            'subject_parent' => 'required',
            'description' => 'required',
            'attachment.*' => 'nullable|mimes:jpg,jpeg,png,svg,pdf,txt',
        ]);
        if ($request->has('attachment')) {
            $file_name = create_name($request->attachment->getclientoriginalname());
            $request->attachment->move(public_path(env('UPLOAD_FILE')), $file_name);
        }


        Ticket::create([
            'user_id' => $request->query('user'),
            'parent_id'=>$request->subject_parent,
            'subject'=>'-',
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
