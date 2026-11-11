<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    protected $fillable = [
        'company_name',
        'company_information',
        'company_address',
        'logo_path',
        'is_accredited',
    ];

    protected function casts(): array
    {
        return [
            'is_accredited' => 'boolean',
        ];
    }
}
