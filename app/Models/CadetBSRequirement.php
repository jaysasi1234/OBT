<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CadetBSRequirement extends Model
{
    protected $table = 'cadet_b_s_requirements';

    protected $fillable = [
        'cadet_id',
        'b_s_requirement_id',
        'attachment',
        'status',
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

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(
            BSRequirement::class,
            'b_s_requirement_id'
        );
    }
}