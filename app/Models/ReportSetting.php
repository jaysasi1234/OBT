<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_name',
        'description',
        'status',
        'include_logo',
        'include_date',
        'report_format',
        'default_title',
        'export_pdf',
        'export_excel',
        'allow_print',
    ];
}