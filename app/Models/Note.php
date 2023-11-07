<?php

namespace App\Models;

use App\Traits\Commentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Note extends Model
{
    use HasFactory, Commentable;

    protected $casts = [
        'deadline_at' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'name',
        'description',
        'deadline_at',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
