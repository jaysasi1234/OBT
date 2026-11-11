<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DownloadableForm extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
        'is_published',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'file_size' => 'integer',
        ];
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}