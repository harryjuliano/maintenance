<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DowntimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'asset_id',
        'downtime_start_at',
        'downtime_end_at',
        'total_minutes',
        'downtime_type',
        'production_impact_note',
        'loss_estimation',
    ];
}
