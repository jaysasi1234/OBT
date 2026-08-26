<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintType extends Model
{
    protected $fillable = [
        'complaint_type',
        'description'
    ];
}