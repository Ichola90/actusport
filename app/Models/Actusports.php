<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Actusports extends Model
{
    protected $fillable = [
        'title',
        'category',
        'image',
        'content',
        'tags',
        'publish_at',
        'author_id',
        'author_type',
    ];

    public function getRouteAttribute()
    {
        return route('actuafrique.detail', ['slug' => $this->slug]);
    }


    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($article) {
            // Création du slug depuis le titre
            $slug = Str::slug($article->title);

            // Vérification des doublons
            $count = Actusports::where('slug', 'like', $slug . '%')->count();
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
