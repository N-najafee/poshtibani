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
    function index()
    {
        if(auth()->user()->getraworiginal('role') === self::USER){
       return redirect()->route('ticket.index');
    }elseif (auth()->user()->getraworiginal('role') === self::POSHTIBAN){
            return redirect()->route('poshtiban.index');
        }else{
            return redirect()->route('admin.index');

        }
    }

}
