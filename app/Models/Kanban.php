<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Kanban extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the kanban.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the notes for the kanban.
     */
    public function notes(): HasManyThrough
    {
        return $this->hasManyThrough(Note::class, Section::class);
    }

    /**
     * Get the sections for the kanban.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }
}
