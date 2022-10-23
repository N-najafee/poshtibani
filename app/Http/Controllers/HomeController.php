<?php

namespace App\Http\Controllers;

use App\Http\Consts\Userconsts;
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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if (auth()->user()->getraworiginal('role') === Userconsts::USER) {
            return redirect()->route('ticket.index');
        } elseif (auth()->user()->getraworiginal('role') === Userconsts::POSHTIBAN) {
            return redirect()->route('response.index');
        } else {
            return redirect()->route('admin.index');

        }
    }
}
