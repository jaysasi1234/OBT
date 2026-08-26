<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CadetProfile extends Model
{
    protected $table = 'cadet_profiles';

    protected $fillable = [
        'user_id',
        'batch',
        'dob',
        'birth_place',
        'address',
        'contact_no',
    ];

    // Relationship: profile belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}