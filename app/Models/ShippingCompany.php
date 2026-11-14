<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    protected $fillable = [
        'company_name',
        'company_information',
        'company_address',
        'marina_accreditation_number',
        'valid_from',
        'valid_until',
        'logo_path',
        'is_accredited',
    ];

    protected function casts(): array
    {
        return [
            'is_accredited' => 'boolean',
            'valid_from' => 'date',
            'valid_until' => 'date',
        ];
    }
}
