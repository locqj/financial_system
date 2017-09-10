<?php

namespace App\Http\Middleware;

use Closure;

use Redirect;

use Session;
class CWorGHMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session('level_code') == 'gh' || session('level_code') == 'cw' || session('level_code') == 'jl')
            return $next($request);
        else
            return Redirect::back();
    }
}
