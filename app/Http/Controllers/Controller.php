<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * The name of the "rol ,status " column.
     *
     * @var integer
     */
    //roles
    const ADMIN= 1;
    const POSHTIBAN = 2;
    const USER =3;
    //status
    const OPEN = 1;
    const COMPLETED =2;
    const CLOSE = 3;
}
