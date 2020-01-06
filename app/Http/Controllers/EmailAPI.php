<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailAPI extends Controller
{
    public function sendEmail(Request $request)
    {

        if($request->has('msg') && $request->has('sourceUser') && $request->has('destUser') ){
            if(auth()->guard('api')->user()->id==$request->sourceUser['id']){
            Mail::raw($request->msg, function ($message) use ($request) {
                $message->subject('Virtual Wallet: income');
                $message->from($request->sourceUser['email']);
                $message->to($request->destUser['email']);
                //$message->to('nunocas3iro@gmail.com');
            });
            }
        }
        return response()->json(['message'=>'Email sent']);

    }

}
