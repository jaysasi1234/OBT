<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CadetDocument extends Model
{
    protected $fillable = [
        'cadet_id',
        'document_id',
        'status',
        'file_path',
        'remarks',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function cadet(): BelongsTo
    {
        return $this->belongsTo(Cadet::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}