<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippedOnOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadet_id',
        'deliberation_date',
        'obt_endorsement_date',
        'so_number',
        'so_date_issued',
        'status',
        'remarks',
    ];

    protected $casts = [
        'deliberation_date' => 'date',
        'obt_endorsement_date' => 'date',
        'so_date_issued' => 'date',
    ];

    /**
     * Relationship to Cadet
     */
    public function cadet()
    {
        return $this->belongsTo(Cadet::class);
    }
}