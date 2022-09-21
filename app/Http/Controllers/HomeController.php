<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use UxWeb\SweetAlert\SweetAlert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->role === "کاربر عادی") {
            return redirect()->route('ticket.index');
        }elseif(auth()->user()->role === "پشتیبان"){
            return redirect()->route('poshtiban.index');
        }
    }


}
