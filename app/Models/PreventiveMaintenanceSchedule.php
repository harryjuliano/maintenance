<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreventiveMaintenanceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'asset_id',
        'schedule_date',
        'due_date',
        'meter_due',
        'generated_work_order_id',
        'status',
        'reschedule_reason',
        'completed_at',
    ];
}
