<?php

namespace App\Http\Middleware;

use Closure;

use Redirect;

use Session;

class cAuthentication
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
        
        /*不是该店的跳会原来请求页面*/
        if(in_array(Session::get('level_code'), ['dz', 'xs', 'zl'])){
            if($request->store_code != Session::get('store_code')) {
                return Redirect::back();
            } else {
                return $next($request);
            }
        } else {
            return $next($request);
        }
        
        
    }
}
