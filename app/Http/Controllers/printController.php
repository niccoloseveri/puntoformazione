<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Models\User;
use Illuminate\Http\Request;

class printController extends Controller
{
    //
    function printContratto($record) {
        $user = User::find($record);
        //$courses = $user->courses;
        //dd($courses);
        return view('contrattotw')->with([
            'user' => $user,
        //    'courses' => $courses,
        ]);
    }

    function printPrivacy($record){
        $user=User::find($record);
        return view('privacyinf')->with([
            'user' => $user,
        ]);
    }

    function printWhatsapp($record){
        $user=User::find($record);
        return view('whatsapp')->with([
            'user' => $user,
        ]);
    }

    function printRicevuta($record){
        $payment=Payments::find($record);
        $user=User::find($payment->users_id);
        $sub=($user->subscriptions()->where('courses_id', $payment->courses_id)->first());
        //dd($sub->paymentoptions->name);
        return view('ricevuta')->with([
            'user' => $user,
            'payment' => $payment,
            'sub' => $sub,
        ]);
    }


}
