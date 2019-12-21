<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailAPI extends Controller
{
    public function sendEmail(Request $request)
    {
        //$user = User::findOrFail($request->id);
      //  let msg = ('Income of ' + this.movement.value + ' euros was sent to your wallet');


if($request->has('msg') && $request->has('sourceUser') && $request->has('destUser') ){

    Mail::raw($request->msg, function ($message) use ($request) {
        $message->subject('Virtual Wallet: income');
        $message->to('nunocas3iro@gmail.com');
        //TODO MUDAR para linha de baixo
        //$message->to($request->destUser['email']);
        $message->from($request->sourceUser['email']);

    });
}




        //return response()->json($request);
        return response()->json(['message'=>'Email sent']);

    }

}
