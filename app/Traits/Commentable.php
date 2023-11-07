<?php

namespace App\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Commentable
{
    public static function bootHasComment(): void
    {
        static::deleting(static function ($model) {
            $model->comments()->delete();
        });
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
