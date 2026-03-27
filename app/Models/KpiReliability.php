<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiReliability extends Model
{
    use HasFactory;

    protected $fillable = [
        'kpi_code',
        'kpi_period',
        'asset_id',
        'mtbf_hours',
        'mttr_hours',
        'availability_pct',
        'breakdown_count',
        'emergency_wo_ratio',
        'pm_compliance',
        'status',
    ];
}
