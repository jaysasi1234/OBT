<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Course;
use App\Models\Cadet;
use App\Models\ChatGroup;

class Batch extends Model
{
    protected $fillable = [
        'batch_year',
    ];

    public function cadets(): HasMany
    {
        return $this->hasMany(Cadet::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(
            Course::class,
            'batch_course'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CHAT GROUP
    |--------------------------------------------------------------------------
    */

    public function chatGroup(): HasOne
    {
        return $this->hasOne(
            ChatGroup::class,
            'batch_id'
        );
    }
}