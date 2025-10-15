<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Celebrite extends Model
{
    //
    protected $fillable = ['title', 'image', 'content', 'publish_at', 'tags', 'author_id', 'author_type'];

    public function getRouteAttribute()
    {
        return route('articles.show.celebrite', ['slug' => $this->slug]);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($article) {
            // Création du slug depuis le titre
            $slug = Str::slug($article->title);

            // Vérification des doublons
            $count = Celebrite::where('slug', 'like', $slug . '%')->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            $article->slug = $slug;
        });
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
