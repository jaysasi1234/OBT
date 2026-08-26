<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function cadet()
    {
        return $this->belongsTo(Cadet::class);
    }

    public function requirement()
    {
        return $this->belongsTo(BSRequirement::class, 'b_s_requirement_id');
    }
}