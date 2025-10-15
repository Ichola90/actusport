<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewArticleMail;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\Wag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class WagsController extends Controller
{
    //
    public function wags()
    {
        $articles = Wag::latest()->get();
        return view('Admin.Pages.Wags.wags', compact('articles'));
    }

    //Afficher les omnisports sur l'acceuil 
    public function showWags()
    {
        $articles = Wag::with('author')
            ->where(function ($query) {
                $query->where('publish_at', '<=', now())
                    ->orWhereNull('publish_at'); // anciens articles sans date
            })
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        $recentPosts = Wag::with('author')
            ->where(function ($query) {
                $query->where('publish_at', '<=', now())
                    ->orWhereNull('publish_at');
            })
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('Users.Pages.Wags.wags', compact('articles', 'recentPosts'));
    }

    public function showdetailWags($slug)
    {
        $article = Wag::where('slug', $slug)->firstOrFail();
        $article->increment('views');
        $recentPosts = Wag::latest()->take(8)->get();
        return view('Users.Pages.Wags.detail', compact('article', 'recentPosts'));
    }

    //formulaire de création
    public function createWag()
    {
        return view('Admin.Pages.Wags.addWags');
    }

    public function storeWag(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:9048',
            'content' => 'required',
            'publish_at' => 'nullable|date',
            'existing_image' => 'nullable|string',
            'tags'    =>    'nullable|string',
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'title.string'   => 'Le titre doit être une chaîne de caractères.',
            'title.max'      => 'La taille maximale du titre est de 255 caractères.',

            'image.required' => 'L\'image est obligatoire.',
            'image.image'    => 'Veuillez importer une image valide.',
            'image.mimes'    => 'L\'image doit être au format: jpeg, png, jpg, gif ou webp.',
            'image.max'      => 'La taille maximale de l\'image est 2Mo.',

            'content.required' => 'Le contenu est obligatoire.',
        ]);

        if ($request->filled('existing_image')) {
            $path = $request->existing_image;
        }

        // Sinon, upload d’une nouvelle image
        elseif ($request->hasFile('image')) {
            // Récupère le nom original de l'image
            $originalName = $request->image->getClientOriginalName();
            // Remplace les caractères spéciaux pour la sécurité
            $safeName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalName);

            // Vérifie si le fichier existe déjà pour éviter les écrasements
            $destination = public_path('articles/' . $safeName);
            $i = 1;
            while (file_exists($destination)) {
                $safeName = pathinfo($originalName, PATHINFO_FILENAME) . "_$i." . $request->image->extension();
                $destination = public_path('articles/' . $safeName);
                $i++;
            }

            // Déplace le fichier vers le dossier public/articles
            $request->image->move(public_path('articles'), $safeName);
            $path = 'articles/' . $safeName;

            // Stocker dans la table medias pour la galerie
            DB::table('medias')->insert([
                'path'       => $path,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //  Déterminer l’auteur selon le guard
        if (Auth::guard('web')->check()) {
            $authorId   = Auth::id();
            $authorType = \App\Models\User::class;
        } elseif (Auth::guard('collaborateur')->check()) {
            $authorId   = Auth::guard('collaborateur')->id();
            $authorType = \App\Models\Collaborateur::class;
        } else {
            return back()->with('error', 'Impossible d’identifier l’auteur.');
        }

        //  Création de l’article Wags avec auteur
        $wags = Wag::create([
            'title'       => $request->title,
            'image'       => $path,
            'content'     => $request->content,
            'tags'        => $request->tags,
            'publish_at'     => $request->publish_at,
            'author_id'   => $authorId,
            'author_type' => $authorType,
        ]);

        // Envoyer le mail à tous les abonnés
        // $subscribers = Subscriber::all();
        // foreach ($subscribers as $subscriber) {
        //     Mail::to($subscriber->email)->send(new NewArticleMail($wags, 'wags'));
        // }

        return redirect()->route('wags')->with('success', 'Article ajouté avec succès !');
    }


    //Modifier
    public function update(Request $request, $id)
    {
        $article = Wag::findOrFail($id);

        $request->validate([
            'title'   => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10048',
            'content' => 'required',
            'publish_at' => 'nullable|date',
            'tags'    =>    'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('articles'), $imageName);
            $article->image = 'articles/' . $imageName;
        }

        $article->title = $request->title;
        $article->content = $request->content;
        $article->publish_at = $request->publish_at;
        $article->tags = $request->tags;
        $article->save();

        return back()->with('success', 'Article mis à jour avec succès !');
    }

    //supprimer
    public function destroy($id)
    {
        $article = Wag::findOrFail($id);
        if ($article->image && file_exists(public_path($article->image))) {
            unlink(public_path($article->image));
        }
        $article->delete();

        return back()->with('success', 'Article supprimé avec succès !');
    }
}
