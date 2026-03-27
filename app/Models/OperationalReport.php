<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_no',
        'report_date',
        'shift',
        'summary',
        'downtime_minutes',
        'breakdown_count',
        'pm_compliance',
        'status',
        'prepared_by',
    ];
}
