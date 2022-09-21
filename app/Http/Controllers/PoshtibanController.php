<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use UxWeb\SweetAlert\SweetAlert;

class PoshtibanController extends Controller
{

    function index(){

        $tickets=Ticket::latest()->paginate(5);
        return view('poshtiban.index',compact('tickets'));
    }

    function create(Ticket $ticket){
        if($ticket->status !== "بسته")
{
return view('poshtiban.create', compact('ticket'));
}

    }

    function store(Request $request, Ticket $ticket){

        $request->validate([
            'text'=>'required',
        ]);
        try {
            DB::beginTransaction();
            Response::create([
                'ticket_id' => $ticket->id,
                'user_id' => auth()->user()->id,
                'description' => trim($request->text),
            ]);
            $ticket->update([
                'status'=>"پاسخ داده شده"
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            alert()->error("خطا در ثبت پاسخ ");
        }
       SweetAlert::success("پاسخ شما با موفقیت ثبت گردید");
        return redirect()->route('poshtiban.index');
    }

}
