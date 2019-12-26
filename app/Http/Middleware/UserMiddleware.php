<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleware
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
        if(auth()->guard('api')->user()!=null){
            if(auth()->guard('api')->user()->type=='u'){
                return $next($request);
            }else{
                return redirect('/#/');
            }
        }else{
            return redirect('/#/');
        }
    }
}
