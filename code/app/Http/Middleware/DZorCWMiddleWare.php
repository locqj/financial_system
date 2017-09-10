<?php

namespace App\Http\Middleware;

use Closure;

use Redirect;

use Session;
class DZorCWMiddleWare
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
        if(session('level_code') == 'dz' || session('level_code') == 'zl' || session('level_code') == 'cw' || session('level_code') == 'jl' || session('level_code') == 'gh' || session('level_code') == 'qy')
            return $next($request);
        else
            return Redirect::back();
    }
}
