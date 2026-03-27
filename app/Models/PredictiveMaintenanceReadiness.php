<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredictiveMaintenanceReadiness extends Model
{
    use HasFactory;

    protected $fillable = [
        'readiness_no',
        'assessment_date',
        'asset_id',
        'data_quality_score',
        'sensor_coverage_pct',
        'failure_model_status',
        'readiness_level',
        'notes',
        'status',
    ];
}
