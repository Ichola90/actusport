<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('getArticleRoute')) {
    function getArticleRoute($article)
    {
        switch ($article->type) {
            case 'mercato':
                return route('articles.show', $article->id);
            case 'actusport':
                return route('actuafrique.detail', $article->id);
            case 'omnisport':
                return route('articles.show.omnisport', $article->id);
            case 'wags':
                return route('articles.show.wags', $article->id);
            case 'celebrite':
                return route('articles.show.celebrite', $article->id);
            default:
                return '#'; // fallback si jamais le type n'est pas reconnu
        }
    }
}
