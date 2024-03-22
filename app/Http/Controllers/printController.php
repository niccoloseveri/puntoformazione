<?php

namespace App\Http\Controllers;

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
}
