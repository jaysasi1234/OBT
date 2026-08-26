<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CadetOnboardRequirement;

class OnboardRequirement extends Model
{
    protected $fillable = [
        'title',
        'description',
        'frequency',
        'due_after_days',
        'is_required',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

public function submissions()
{
    return $this->hasMany(
        CadetOnboardRequirement::class,
        'onboard_requirement_id'
    );
}

    public function cadetRequirements()
{
    return $this->hasMany(
        CadetOnboardRequirement::class
    );
}
}