<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Document extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_required',
        'course'
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    // One document → many cadet submissions
    public function cadetDocuments(): HasMany
    {
        return $this->hasMany(CadetDocument::class);
    }

    // Many-to-many (ONLY if you use pivot access)
    public function cadets(): BelongsToMany
    {
        return $this->belongsToMany(Cadet::class, 'cadet_documents')
            ->withPivot([
                'status',
                'file_path',
                'remarks',
                'submitted_at'
            ])
            ->withTimestamps();
    }
}