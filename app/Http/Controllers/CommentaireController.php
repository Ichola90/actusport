<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
  public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:150',
        'comment' => 'required|string|max:1000',
        'commentable_id' => 'required|integer',
        'commentable_type' => 'required|string',
    ]);

    $commentableType = $request->commentable_type;
    $commentableId = $request->commentable_id;

    $commentable = $commentableType::findOrFail($commentableId);

    $commentable->comments()->create([
        'name' => $request->name,
        'email' => $request->email,
        'comment' => $request->comment,
    ]);

    return back()->with('success', 'Votre commentaire a été envoyé avec succès !');
}

}
