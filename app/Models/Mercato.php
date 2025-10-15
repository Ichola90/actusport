<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mercato extends Model
{
    protected $fillable = [
        'title',
        'image',
        'content',
        'author_id',
        'author_type',
        'publish_at',
        'tags',
        'categorie'
        // 'slug' sera généré automatiquement
    ];

    /**
     * Génération automatique du slug lors de la création
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($article) {
            // Création du slug depuis le titre
            $slug = Str::slug($article->title);

            // Vérification des doublons
            $count = Mercato::where('slug', 'like', $slug . '%')->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            $article->slug = $slug;
        });
    }

    /**
     * URL lisible pour l'article
     */
    public function getRouteAttribute(): string
    {
        return route('articles.show', ['slug' => $this->slug]);
    }

    /**
     * Relation polymorphe avec l'auteur
     */
    public function author()
    {
        return $this->morphTo();
    }

    /**
     * Relation polymorphe avec les commentaires
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
