<?php

namespace App\Http\Controllers;

use App\Models\Actusports;
use App\Models\Celebrite;
use App\Models\Mercato;
use App\Models\Omnisport;
use App\Models\Wag;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AllarticleController extends Controller
{
    public function allArticles()
    {
        $mercato   = Mercato::where(function ($q) {
                        $q->where('publish_at', '<=', now())
                          ->orWhereNull('publish_at');
                    })->get()->each->setAttribute('type', 'mercato');

        $omnisport = Omnisport::where(function ($q) {
                        $q->where('publish_at', '<=', now())
                          ->orWhereNull('publish_at');
                    })->get()->each->setAttribute('type', 'omnisport');

        $wags      = Wag::where(function ($q) {
                        $q->where('publish_at', '<=', now())
                          ->orWhereNull('publish_at');
                    })->get()->each->setAttribute('type', 'wags');

        $celebrite = Celebrite::where(function ($q) {
                        $q->where('publish_at', '<=', now())
                          ->orWhereNull('publish_at');
                    })->get()->each->setAttribute('type', 'celebrite');

        $actusport = Actusports::where(function ($q) {
                        $q->where('publish_at', '<=', now())
                          ->orWhereNull('publish_at');
                    })->get()->each->setAttribute('type', 'actusport');

        // Fusion des articles
        $articles = collect()
            ->merge($mercato)
            ->merge($omnisport)
            ->merge($wags)
            ->merge($celebrite)
            ->merge($actusport)
            ->sortByDesc('created_at');

        // Transformer la collection en pagination (25 par page)
        $page = request()->get('page', 1);
        $perPage = 25;
        $paginated = new LengthAwarePaginator(
            $articles->forPage($page, $perPage),
            $articles->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('Users.Pages.Allarticle.all-article', ['articles' => $paginated]);
    }
}
