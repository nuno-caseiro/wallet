<?php

namespace App\Http\Middleware;

use Closure;

class ForAll
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
            if(auth()->guard('api')->user()->type=='u' || auth()->guard('api')->user()->type=='o'  || auth()->guard('api')->user()->type=='a'){
                return $next($request);
            }else{
                return redirect('/#/');
            }
        }else{
            return redirect('/#/');
        }
    }
}
