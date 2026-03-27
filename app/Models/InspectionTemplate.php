<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'inspection_type',
        'code',
        'name',
        'frequency_unit',
        'frequency_value',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
