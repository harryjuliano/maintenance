<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'request_no',
        'request_date',
        'request_time',
        'requested_by',
        'department',
        'asset_id',
        'area_id',
        'production_line_id',
        'request_type',
        'urgency_level',
        'impact_level',
        'title',
        'description',
        'symptom',
        'breakdown_start_at',
        'affects_production',
        'estimated_production_loss',
        'status',
    ];

    protected $casts = [
        'affects_production' => 'boolean',
    ];
}
