<?php

namespace App\Http\Middleware;

use App\Http\Consts\Userconsts;
use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->getraworiginal('role') === Userconsts::ADMIN) {
            return $next($request);
        } else {
            return redirect('home');
        }
    }
}
