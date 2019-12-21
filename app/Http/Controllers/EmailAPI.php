<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailAPI extends Controller
{
    public function sendEmail()
    {
        //$user = User::findOrFail($request->id);

        Mail::raw('Hi, welcome user!', function ($message) {
            $message->to('nunocas3iro@gmail.com');
        });

        return response()->json(['message' => 'Email sent']);

    }

}
