<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlannerCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_no',
        'title',
        'plan_date',
        'start_time',
        'end_time',
        'asset_id',
        'work_order_id',
        'assigned_to',
        'plan_type',
        'priority',
        'status',
        'note',
    ];
}
