<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mdpLostController extends Controller
{
    public function mdpLost()
    {
        return view('mdp-lost');
    }

    public function mdpLostProcess(Request $request)
    {
        return view('mdp-lost');
    }
}