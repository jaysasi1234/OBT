<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CadetInsurance extends Model
{
    protected $fillable = [
        'cadet_id',
        'uploaded_by',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
        'expiration_date',
        'expiry_warning_sent_at',
        'expired_notified_at',
    ];

    protected function casts(): array
    {
        return [
            'expiration_date' => 'date',
            'expiry_warning_sent_at' => 'datetime',
            'expired_notified_at' => 'datetime',
        ];
    }

    public function cadet(): BelongsTo
    {
        return $this->belongsTo(Cadet::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
