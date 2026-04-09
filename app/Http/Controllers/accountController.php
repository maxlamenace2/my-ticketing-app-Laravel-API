<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class accountController extends Controller
{
    public function myAccount()
    {
        $user = Auth::user(); 
        return view('my-account', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', 
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
        
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }
       
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Votre mot de passe a bien été modifié !');
    }
}