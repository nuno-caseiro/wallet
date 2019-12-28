<?php

namespace App\Http\Middleware;

use Closure;

class CheckMiddleware
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
            if(auth()->guard('api')->user()->type=='a' || auth()->guard('api')->user()->type=='o' || auth()->guard('api')->user()->type=='u'){
                return $next($request);
            }else{
                return redirect('/#/');
            }
        }

    }
}
