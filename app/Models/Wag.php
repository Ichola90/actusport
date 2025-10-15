<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Wag extends Model
{
    //
    protected $fillable = [
        'title',
        'image',
        'content',
        'tags',
        'publish_at',
        'author_id',
        'author_type',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($article) {
            // Création du slug depuis le titre
            $slug = Str::slug($article->title);

            // Vérification des doublons
            $count = Wag::where('slug', 'like', $slug . '%')->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            $article->slug = $slug;
        });
    }


    public function getRouteAttribute()
    {
        return route('articles.show.wags', ['slug' => $this->slug]);
    }

    public function author()
    {
        return $this->morphTo();
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
