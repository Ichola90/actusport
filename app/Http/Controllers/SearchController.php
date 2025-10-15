<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mercato;
use App\Models\Actusports;
use App\Models\Wag;
use App\Models\Omnisport;
use App\Models\Celebrite;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    // 🔍 AJAX suggestions
    public function ajaxSearch(Request $request)
    {
        $q = $request->input('q');

        $mercatos = Mercato::where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->get();

        $actus = Actusports::where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->get();

        $wags = Wag::where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->get();

        $omnisports = Omnisport::where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->get();

        $celebrites = Celebrite::where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->get();

        $all = $mercatos->merge($actus)->merge($wags)->merge($omnisports)->merge($celebrites);

        $results = $all->map(function ($article) {
            $url = '#';
            if ($article->type === 'mercato') $url = route('articles.show', $article->slug);
            if ($article->type === 'actusport') $url = route('actuafrique.detail', $article->slug);
            if ($article->type === 'wags') $url = route('articles.show.wags', $article->slug);
            if ($article->type === 'omnisport') $url = route('articles.show.omnisport', $article->slug);
            if ($article->type === 'celebrite') $url = route('articles.show.celebrite', $article->slug);

            return [
                'title' => $article->title,
                'type' => $article->type,
                'url' => $url
            ];
        });

        return response()->json($results);
    }


    // Page complète



    public function results(Request $request)
    {
        $q = $request->input('q');

        $mercatos = Mercato::where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->get()
            ->map(fn($a) => $a->setAttribute('type', 'mercato'));

        $actus = Actusports::where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->get()
            ->map(fn($a) => $a->setAttribute('type', 'actusport'));

        $wags = Wag::where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->get()
            ->map(fn($a) => $a->setAttribute('type', 'wags'));

        $omnisports = Omnisport::where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->get()
            ->map(fn($a) => $a->setAttribute('type', 'omnisport'));

        $celebrites = Celebrite::where('title', 'like', "%{$q}%")
            ->orWhere('content', 'like', "%{$q}%")
            ->get()
            ->map(fn($a) => $a->setAttribute('type', 'celebrite'));

        $all = $mercatos->merge($actus)->merge($wags)->merge($omnisports)->merge($celebrites);

        $page = $request->get('page', 1);
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        $articles = new LengthAwarePaginator(
            $all->slice($offset, $perPage)->values(),
            $all->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('Users.search.results', compact('q', 'articles'));
    }
}
