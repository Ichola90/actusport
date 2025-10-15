<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    //
    public function loginShow()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        //  Tentative avec le guard "web" (admin/utilisateur)
        if (Auth::guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $remember)) {
            return redirect()->route('dashboard')->with('success', 'Connexion réussie  !');
        }

        //  Tentative avec le guard "collaborateur"
        if (Auth::guard('collaborateur')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $remember)) {
            $collaborateur = Auth::guard('collaborateur')->user();

            // Vérifier si le compte est suspendu
            if (!$collaborateur->is_active) {
                Auth::guard('collaborateur')->logout();
                return redirect()->route('login.show')
                    ->with('error', 'Votre compte est suspendu, contactez l’administrateur.');
            }

            return redirect()->route('mercato')->with('success', 'Connexion réussie en tant que collaborateur !');
        }

        // Si aucun guard ne fonctionne
        return back()->withInput()->with('error', 'Identifiants incorrects.');
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('success', 'Déconnecté avec succès !');
    }
}
