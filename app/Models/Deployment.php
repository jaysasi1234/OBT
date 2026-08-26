<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deployment extends Model
{
    protected $fillable = [
        'cadet_id',
        'user_id',
        'status',
        'percentage',
        'company_name',
        'vessel_name',
        'deployment_type',  
        'vessel_name',
        'embarkation_place',
        'date_deployed',
        'disembarkation_place',
        'date_disembarked',
        'expected_completion',
        'notes',
    ];

    protected $casts = [
        'date_deployed' => 'date',
        'date_disembarked' => 'date',
        'expected_completion' => 'date',
    ];

public function onboardRequirements()
{
    return $this->hasMany(CadetOnboardRequirement::class);
}

    // =========================
    // CADET RELATIONSHIP
    // =========================
    public function cadet(): BelongsTo
    {
        return $this->belongsTo(Cadet::class);
    }

    // =========================
    // USER RELATIONSHIP
    // =========================
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =========================
    // AUTO STATUS ACCESSOR
    // =========================
    public function getStatusBadgeAttribute()
    {
        return strtolower(str_replace(' ', '-', $this->status));
    }

    // =========================
    // AUTO PROGRESS CHECK
    // =========================
    public function updateStatus()
    {
        if ($this->percentage >= 100) {

            $this->status = 'Completed';

        } elseif ($this->percentage <= 0) {

            $this->status = 'Not Started';

        } else {

            $this->status = 'Ongoing';
        }

        $this->save();
    }
}