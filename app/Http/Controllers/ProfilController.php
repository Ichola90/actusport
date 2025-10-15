<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfilController extends Controller
{
    public function showProfile()
    {
        return view('Admin.Pages.Profile.profile');
    }

    public function update(Request $request)
    {
        // Récupérer l'utilisateur connecté
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $isCollaborateur = false;
        } elseif (Auth::guard('collaborateur')->check()) {
            $user = Auth::guard('collaborateur')->user();
            $isCollaborateur = true;
        } else {
            return redirect()->back()->with('error', 'Utilisateur non authentifié.');
        }

        // Définir les règles de validation
        $rules = $isCollaborateur
            ? [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:collaborateurs,email,' . $user->id,
                'password' => 'nullable|string|min:6|confirmed',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'about' => 'nullable|string|max:1000',
            ]
            : [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:6|confirmed',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'about' => 'nullable|string|max:1000',
            ];

        $validated = $request->validate($rules);

        // Mettre à jour les champs
        if ($isCollaborateur) {
            $user->nom = $validated['nom'];
            $user->prenom = $validated['prenom'];
            $user->email = $validated['email'];
        } else {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
        }

        // Mot de passe si rempli
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // About
        $user->about = $validated['about'] ?? $user->about;

        // Photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . Str::slug($user->name ?? ($user->prenom . ' ' . $user->nom)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/users'), $filename);
            $user->photo = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil mis à jour avec succès !');
    }
}
