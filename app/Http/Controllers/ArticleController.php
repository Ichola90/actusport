<?php

namespace App\Http\Controllers;

use App\Mail\NewArticleMail;

use App\Models\Mercato;
use App\Models\Actusports;
use App\Models\Wag;
use App\Models\Omnisport;
use App\Models\Celebrite;
use App\Models\Collaborateur;
use App\Models\Media;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class ArticleController extends Controller
{

    public function mercato()
    {

        $articles = Mercato::withCount('comments')->latest()->get();
        return view('Admin.Pages.Mercato.mercato', compact('articles'));
    }

    public function showmercato()
    {
        $articles = Mercato::with('author')
            ->where('categorie', 'europe')
            ->where(function ($query) {
                $query->where('publish_at', '<=', now())
                    ->orWhereNull('publish_at');
            })
            ->latest()
            ->paginate(4);

        $recentPosts = Mercato::with('author')
            ->where(function ($query) {
                $query->where('publish_at', '<=', now())
                    ->orWhereNull('publish_at');
            })
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('Users.Pages.Mercato.mercato-europe', compact('articles', 'recentPosts'));
    }


    public function showmercatoafrique()
    {
        $articlesafrique = Mercato::with('author')
            ->where('categorie', 'afrique')
            ->where(function ($query) {
                $query->where('publish_at', '<=', now())
                    ->orWhereNull('publish_at');
            })
            ->latest()
            ->paginate(4);

        $recentPosts = Mercato::with('author')
            ->where(function ($query) {
                $query->where('publish_at', '<=', now())
                    ->orWhereNull('publish_at');
            })
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('Users.Pages.Mercato.mercato-afrique', compact('articlesafrique', 'recentPosts'));
    }



    public function showdetail($slug)
    {
        $article = Mercato::where('slug', $slug)->firstOrFail();
        $article->increment('views');
        $recentPosts = Mercato::latest()->take(8)->get();

        return view('Users.Pages.Mercato.detail-article', compact('article', 'recentPosts'));
    }



    public function addMercato()
    {
        $medias = Media::all();
        return view('Admin.Pages.Mercato.add_mercato', compact('medias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:9048',
            'content'   => 'required',
            'tags'      => 'nullable|string',
            'publish_at' => 'nullable|date',
            'categorie' => 'required|in:afrique,europe',
            'existing_image' => 'nullable|string'
        ]);

        $path = null;

        // Si une image existante a été sélectionnée
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

        // Auteur selon le guard
        if (Auth::guard('web')->check()) {
            $authorId   = Auth::id();
            $authorType = User::class;
        } elseif (Auth::guard('collaborateur')->check()) {
            $authorId   = Auth::guard('collaborateur')->id();
            $authorType = Collaborateur::class;
        } else {
            return back()->with('error', 'Impossible d’identifier l’auteur.');
        }

        Mercato::create([
            'title'       => $request->title,
            'image'       => $path,
            'content'     => $request->content,
            'categorie'   => $request->categorie,
            'tags'        => $request->tags,
            'publish_at'  => $request->publish_at ?? now(),
            'author_id'   => $authorId,
            'author_type' => $authorType,
        ]);

        return redirect()->route('mercato')->with('success', 'Article ajouté avec succès !');
    }

    //nice done on it
    public function showByMonth($month)
    {
        $month = (int) $month;
        $year = now()->year;

        $models = [
            \App\Models\Mercato::class,
            \App\Models\Omnisport::class,
            \App\Models\Wag::class,
            \App\Models\Celebrite::class,
            \App\Models\Actusports::class,
        ];

        $articles = collect();

        foreach ($models as $model) {
            $table = (new $model)->getTable();
            $columns = \Schema::getColumnListing($table);

            $select = array_intersect($columns, ['id', 'title', 'slug', 'image', 'views', 'category', 'content', 'tags', 'publish_at', 'created_at']);

            $data = $model::select($select)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get()
                ->map(function ($item) use ($model, $columns) {
                    $item->source = class_basename($model);
                    if (!in_array('category', $columns)) {
                        $item->category = 'N/A';
                    }
                    return $item;
                });

            $articles = $articles->merge($data);
        }

        // Tri par vues décroissantes
        $articles = $articles->sortByDesc('views')->values();

        // Pagination manuelle
        $perPage = 10;
        $page = request()->get('page', 1);
        $paged = $articles->slice(($page - 1) * $perPage, $perPage)->values();
        $paginatedArticles = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $articles->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('Admin.articles.by-month', [
            'actualites' => $paginatedArticles,
            'month' => $month,
        ]);
    }

    public function update(Request $request, $id)
    {
        $article = Mercato::findOrFail($id);

        $request->validate([
            'title'   => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10048',
            'content' => 'required',
            'tags' => 'nullable|string',
            'categorie' => 'required|in:afrique,europe',
            'publish_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('articles'), $imageName);
            $article->image = 'articles/' . $imageName;
        }

        $article->title = $request->title;
        $article->content = $request->content;
        $article->tags = $request->tags;
        $article->categorie = $request->categorie;
        $article->publish_at = $request->publish_at;
        $article->save();

        return back()->with('success', 'Article mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $article = Mercato::findOrFail($id);
        if ($article->image && file_exists(public_path($article->image))) {
            unlink(public_path($article->image));
        }
        $article->delete();

        return back()->with('success', 'Article supprimé avec succès !');
    }



    public function showActu()
    {
        $actualites = Actusports::withCount('comments')->latest()->get();
        return view('Admin.Pages.ActuSport.actusport', compact('actualites'));
    }

    public function AddActus()
    {
        $medias = Media::all();
        return view('Admin.Pages.ActuSport.add-actusport', compact('medias'));
    }


    public function storeactus(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:9048',
            'category'  => 'required|string|in:Europe,Afrique',
            'existing_image' => 'nullable|string',
            'content'   => 'required',
            'publish_at' => 'nullable|date',
            'tags' => 'nullable|string'
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            // Récupérer le nom original
            $originalName = $request->image->getClientOriginalName();

            // Nettoyer le nom pour éviter les caractères spéciaux
            $safeName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalName);

            // Déplacer le fichier dans le dossier public/actualites
            $request->image->move(public_path('actualites'), $safeName);

            // Définir le chemin pour la DB
            $path = 'actualites/' . $safeName;

            // Stocker dans la table medias
            DB::table('medias')->insert([
                'path' => $path,
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

        // Création de l’actualité avec auteur
        $actus = ActuSports::create([
            'title'       => $request->title,
            'image'       => $path,
            'category'    => $request->category,
            'content'     => $request->content,
            'publish_at'  => $request->publish_at ?? now(),
            'tags'     => $request->tags,
            'author_id'   => $authorId,
            'author_type' => $authorType,
        ]);

        // Envoi du mail aux abonnés
        // $subscribers = Subscriber::all();
        // foreach ($subscribers as $subscriber) {
        //     Mail::to($subscriber->email)->send(new NewArticleMail($actus, 'actusport'));
        // }

        return redirect()->route('show.actu')->with('success', 'Actualité ajoutée avec succès !');
    }


    public function updateactu(Request $request, $id)
    {
        $article = Actusports::findOrFail($id);

        $request->validate([
            'title'   => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10048',
            'content' => 'required',
            'publish_at' => 'nullable|date',
            'tags' => 'nullable|string',
            'category' => 'required|in:Europe,Afrique',
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
        $article->category = $request->category;
        $article->save();

        return back()->with('success', 'Article mis à jour avec succès !');
    }

    public function destroyactu($id)
    {
        $article = Actusports::findOrFail($id);
        if ($article->image && file_exists(public_path($article->image))) {
            unlink(public_path($article->image));
        }
        $article->delete();

        return back()->with('success', 'Article supprimé avec succès !');
    }


    public function ShowActusAfrique()
    {
        $articlesafriques = Actusports::where('category', 'Afrique')
            ->where(function ($query) {
                $query->where('publish_at', '<=', now())
                    ->orWhereNull('publish_at'); // anciens articles sans date
            })
            ->latest()
            ->paginate(4);

        $recentPostsAfrique = Actusports::where(function ($query) {
            $query->where('publish_at', '<=', now())
                ->orWhereNull('publish_at');
        })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('Users.Pages.ActuSport.actusport-afrique', compact('articlesafriques', 'recentPostsAfrique'));
    }

    public function ShowActusEurope()
    {
        $articlesafriques = Actusports::where('category', 'Europe')
            ->where(function ($query) {
                $query->where('publish_at', '<=', now())
                    ->orWhereNull('publish_at');
            })
            ->latest()
            ->paginate(4);

        $recentPostsAfrique = Actusports::where(function ($query) {
            $query->where('publish_at', '<=', now())
                ->orWhereNull('publish_at');
        })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('Users.Pages.ActuSport.actusport-europe', compact('articlesafriques', 'recentPostsAfrique'));
    }



    public function showdetailafrique($slug)
    {

        $articlesafrique = Actusports::where('slug', $slug)->firstOrFail();

        $articlesafrique->increment('views');

        $recentPostsAfrique = Actusports::latest()->take(8)->get();

        return view('Users.Pages.ActuSport.detail-actuafrique', compact('articlesafrique', 'recentPostsAfrique'));
    }



    //recherche
    public function searchmercato(Request $request)
    {
        $query = $request->get('query');

        // Cherche les articles contenant le terme
        $articles = Mercato::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Retourne une vue partielle pour AJAX
        return view('partials.search-mercato', compact('articles'));
    }



    public function articlesByTag($tag)
    {
        // Décoder le tag depuis l'URL
        $tag = urldecode($tag);

        // Construire les requêtes pour chaque table en incluant 'content'
        $mercato = DB::table('mercatos')
            ->select('id', 'title', 'slug', 'image', 'tags', 'content', 'created_at', DB::raw("'Mercato' as category"))
            ->where('tags', 'LIKE', '%' . $tag . '%');

        $actusports = DB::table('actusports')
            ->select('id', 'title', 'slug', 'image', 'tags', 'content', 'created_at', DB::raw("'ActuSport' as category"))
            ->where('tags', 'LIKE', '%' . $tag . '%');

        $wag = DB::table('wags')
            ->select('id', 'title', 'slug', 'image', 'tags', 'content', 'created_at', DB::raw("'Wag' as category"))
            ->where('tags', 'LIKE', '%' . $tag . '%');

        $celebrite = DB::table('celebrites')
            ->select('id', 'title', 'slug', 'image', 'tags', 'content', 'created_at', DB::raw("'Célébrité' as category"))
            ->where('tags', 'LIKE', '%' . $tag . '%');

        $omnisport = DB::table('omnisports')
            ->select('id', 'title', 'slug', 'image', 'tags', 'content', 'created_at', DB::raw("'Omnisport' as category"))
            ->where('tags', 'LIKE', '%' . $tag . '%');

        // Fusionner toutes les requêtes avec UNION ALL
        $query = $mercato
            ->unionAll($actusports)
            ->unionAll($wag)
            ->unionAll($celebrite)
            ->unionAll($omnisport);

        // Sous-requête pour permettre la pagination
        $articles = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('Users.Pages.Allarticle.byTag', compact('articles', 'tag'));
    }

    public function getMedias(Request $request)
    {
        $query = DB::table('medias')->orderBy('created_at', 'desc');

        // Filtre par recherche
        if ($request->has('search') && $request->search != '') {
            $query->where('path', 'like', '%' . $request->search . '%');
        }

        $medias = $query->paginate(20);

        // Retour JSON pour JS
        return response()->json($medias);
    }

    public function byAuthor($type, $id, Request $request)
    {
        // Normaliser le type en classe (adapter si tu utilises un autre nom)
        if ($type === 'collaborateur') {
            $authorClass = Collaborateur::class;
            $author = Collaborateur::findOrFail($id);
            $authorName = trim(($author->prenom ?? '') . ' ' . ($author->nom ?? ''));
        } else { // 'user' par défaut
            $authorClass = User::class;
            $author = User::findOrFail($id);
            $authorName = $author->name ?? ($author->prenom ?? $author->nom ?? 'Auteur');
        }

        // Récupérer les articles par modèle en filtrant SUR LES DEUX champs
        $mercatos = Mercato::where('author_id', $id)
            ->where('author_type', $authorClass)
            ->get()->each->setAttribute('type', 'mercato');

        $actusports = Actusports::where('author_id', $id)
            ->where('author_type', $authorClass)
            ->get()->each->setAttribute('type', 'actusport');

        $wags = Wag::where('author_id', $id)
            ->where('author_type', $authorClass)
            ->get()->each->setAttribute('type', 'wags');

        $omnisports = Omnisport::where('author_id', $id)
            ->where('author_type', $authorClass)
            ->get()->each->setAttribute('type', 'omnisport');

        $celebrites = Celebrite::where('author_id', $id)
            ->where('author_type', $authorClass)
            ->get()->each->setAttribute('type', 'celebrite');

        // Fusionner et trier par date de création
        $all = $mercatos->merge($actusports)->merge($wags)->merge($omnisports)->merge($celebrites)
            ->sortByDesc('created_at')
            ->values();

        // Pagination manuelle (LengthAwarePaginator)
        $page = $request->get('page', 1);
        $perPage = 12; // adapte si tu veux
        $offset = ($page - 1) * $perPage;
        $itemsForCurrentPage = $all->slice($offset, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $itemsForCurrentPage,
            $all->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('Users.Pages.Allarticle.byAuthor', [
            'author' => $author,
            'authorName' => $authorName,
            'articles' => $paginator
        ]);
    }
}
