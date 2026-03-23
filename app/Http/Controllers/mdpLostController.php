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
        // Valider et enregistrer l'utilisateur ici
        // dd($request->all()); // Pour tester si les données arrivent bien
        return view('mdp-lost');
    }
}