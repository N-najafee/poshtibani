<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Ticket;
use Database\Factories\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use UxWeb\SweetAlert\SweetAlert;

class PoshtibanController extends Controller
{


    public function __construct()
    {
        if (!auth()->user()) {
            $this->middleware('auth');
        }
    }

    function index()
    {
//        ResponseFactory::new()->count(5)->create();
        $tickets = Ticket::where('parent_id', '!=', 0)->latest()->paginate(5);
        return view('poshtiban.index', compact('tickets'));
    }

    function create_response(Ticket $ticket)
    {

        return view('poshtiban.response', compact('ticket'));
    }


    function store_response(Request $request, Ticket $ticket)
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
        return redirect()->route('poshtiban.index');
    }

}
