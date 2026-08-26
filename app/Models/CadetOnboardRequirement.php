<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CadetOnboardRequirement extends Model
{
    protected $fillable = [
        'cadet_id',
        'onboard_requirement_id',
        'status',
        'submitted_at',
        'approved_at',
        'approved_by',
        'remarks',
        'attachment',
    ];

    public function cadet()
    {
        return $this->belongsTo(Cadet::class);
    }

    public function requirement()
    {
        return $this->belongsTo(OnboardRequirement::class, 'onboard_requirement_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}