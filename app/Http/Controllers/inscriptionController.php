<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 

class inscriptionController extends Controller
{
    public function inscription()
    {
        return view('inscription');
    }

    public function inscriptionProcess(Request $request)
    {
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'birthdate' => 'required|date',
            'password' => 'required|string|min:8', 
        ]);

        $user = User::create([
            'lastname' => $validated['lastname'],
            'firstname' => $validated['firstname'],
            'email' => $validated['email'],
            'birthdate' => $validated['birthdate'],
            'password' => Hash::make($validated['password']), 
        ]);

        return redirect()->route('login')->with('success', 'Votre compte a été créé avec succès !');
    }
}