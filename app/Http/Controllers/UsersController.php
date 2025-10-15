<?php

namespace App\Http\Controllers;

use App\Models\Mercato;
use App\Models\Actusports;
use App\Models\Celebrite;
use App\Models\Omnisport;
use App\Models\Wag;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        // Helper interne pour récupérer les articles par table en tenant compte de publish_at
        $getArticles = function ($model, $type, $limit = 2, $extraQuery = null) {
            $query = $model::with('author')
                ->where(function ($q) {
                    $q->where('publish_at', '<=', now())
                      ->orWhereNull('publish_at'); // inclut les anciens articles sans date
                })
                ->orderByDesc('views');

            if ($extraQuery) {
                $query = $extraQuery($query);
            }

            return $query->take($limit)->get()->each->setAttribute('type', $type);
        };

        // Récupération par catégories
        $mercato   = $getArticles(Mercato::class, 'mercato');
        $omnisport = $getArticles(Omnisport::class, 'omnisport');
        $wags      = $getArticles(Wag::class, 'wags');
        $celebrite = $getArticles(Celebrite::class, 'celebrite');

        // Actusports
        $afrique = $getArticles(
            Actusports::class,
            'actusport',
            2,
            fn($q) => $q->where('category', 'afrique')
        );

        $europe = $getArticles(
            Actusports::class,
            'actusport',
            2,
            fn($q) => $q->where('category', 'europe')
        );

        // Section “Featured Posts” (slider) → triés par popularité
        $featuredArticles = collect()
            ->merge($mercato)
            ->merge($omnisport)
            ->merge($wags)
            ->merge($celebrite)
            ->merge($afrique)
            ->merge($europe)
            ->sortByDesc('views')
            ->take(6);

        // Blog principal (les 5 derniers articles publiés, toutes catégories confondues)
        $articles = collect()
            ->merge(Mercato::with('author')->where(function ($q) { $q->where('publish_at', '<=', now())->orWhereNull('publish_at'); })->latest()->take(5)->get())
            ->merge(Omnisport::with('author')->where(function ($q) { $q->where('publish_at', '<=', now())->orWhereNull('publish_at'); })->latest()->take(5)->get())
            ->merge(Wag::with('author')->where(function ($q) { $q->where('publish_at', '<=', now())->orWhereNull('publish_at'); })->latest()->take(5)->get())
            ->merge(Celebrite::with('author')->where(function ($q) { $q->where('publish_at', '<=', now())->orWhereNull('publish_at'); })->latest()->take(5)->get())
            ->merge(Actusports::with('author')->where(function ($q) { $q->where('publish_at', '<=', now())->orWhereNull('publish_at'); })->latest()->take(5)->get())
            ->sortByDesc(fn($item) => $item->created_at)
            ->take(5);

        // Section “Category Section”
        $allForCategory = collect()
            ->merge($mercato)
            ->merge($omnisport)
            ->merge($wags)
            ->merge($celebrite)
            ->merge($afrique)
            ->merge($europe)
            ->sortByDesc('views');

        $featuredCategoryArticles = $allForCategory->take(3);
        $listCategoryArticles = $allForCategory->skip(3)->take(6);

        // Section “Derniers articles” (par date)
        $latestArticles = collect()
            ->merge($mercato)
            ->merge($omnisport)
            ->merge($wags)
            ->merge($celebrite)
            ->merge($afrique)
            ->merge($europe)
            ->sortByDesc(fn($item) => $item->created_at)
            ->take(6)
            ->map(fn($article) => ['article' => $article, 'type' => $article->type]);

        // Nombre total d'articles
        $totalArticles =
            Mercato::count() +
            Omnisport::count() +
            Wag::count() +
            Celebrite::count() +
            Actusports::count();

        return view('Users.index', compact(
            'featuredArticles',
            'articles',
            'featuredCategoryArticles',
            'listCategoryArticles',
            'latestArticles',
            'totalArticles'
        ));
    }
}
