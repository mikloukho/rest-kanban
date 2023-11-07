<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * Get the kanban that owns the section.
     */
    public function kanban(): BelongsTo
    {
        return $this->belongsTo(Kanban::class);
    }

    /**
     * Get the notes for the section.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
