<?php

namespace App\Http\Controllers;

use App\Models\Collaborateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CollaborateurController extends Controller
{
     public function index()
    {
       $collaborateurs = Collaborateur::all();
        return view('Admin.Pages.Collab.collab', compact('collaborateurs')); 
    }

     // Créer un collaborateur
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:collaborateurs,email',
            'password' => 'required|min:6',
        ]);

        Collaborateur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Collaborateur ajouté avec succès');
    }

      // Modifier un collaborateur
    public function update(Request $request, Collaborateur $user)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:collaborateurs,email,' . $user->id,
        ]);

        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => $request->password 
                ? Hash::make($request->password) 
                : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Collaborateur mis à jour avec succès');
    }

        // Supprimer un collaborateur
    public function destroy(Collaborateur $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Collaborateur supprimé avec succès');
    }

    // Suspendre un collaborateur
    public function suspend(Collaborateur $user)
    {
        $user->update(['is_active' => false]);
        return redirect()->route('admin.users.index')->with('success', 'Collaborateur suspendu');
    }

    // Réactiver un collaborateur
    public function activate(Collaborateur $user)
    {
        $user->update(['is_active' => true]);
        return redirect()->route('admin.users.index')->with('success', 'Collaborateur réactivé');
    }


}
