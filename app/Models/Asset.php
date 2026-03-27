<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'asset_category_id',
        'plant_id',
        'area_id',
        'production_line_id',
        'asset_code',
        'asset_name',
        'asset_number',
        'criticality_level',
        'maintenance_strategy',
        'status',
        'location_note',
        'notes',
    ];
}
