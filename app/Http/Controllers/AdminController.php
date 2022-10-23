<?php

namespace App\Http\Controllers;

use App\Http\Consts\Ticketconsts;
use App\Models\Response;
use App\Models\Subject;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\SubjectPolicy;
use Illuminate\Auth\Access\Gate;

class AdminController extends Controller
{

    public function __construct()
    {

    }


    public function index()
    {

        $users = User::orderby('created_at', 'DESC')->get();
        $subjects = Subject::all();
        $tickets = Ticket::withTrashed()->orderBy('created_at', 'DESC')->get();
        return view('admin.index', compact('tickets', 'subjects', 'users'));
    }

}
