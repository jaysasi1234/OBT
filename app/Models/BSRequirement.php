<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BSRequirement extends Model
{
    protected $table = 'bs_requirements';

    protected $fillable = [
        'title',
        'description',
        'is_required',
        'is_active',
        'sort_order',
    ];

    public function submissions(): HasMany
    {
        return $this->hasMany(
            CadetBSRequirement::class,
            'b_s_requirement_id'
        );
    }
}