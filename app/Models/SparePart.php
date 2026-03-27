<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'spare_part_category_id',
        'supplier_id',
        'part_code',
        'part_name',
        'part_number',
        'brand',
        'specification',
        'unit',
        'criticality_level',
        'min_stock',
        'max_stock',
        'reorder_point',
        'lead_time_days',
        'unit_cost',
        'active',
        'notes',
    ];
}
