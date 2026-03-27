<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalibrationSupport extends Model
{
    use HasFactory;

    protected $fillable = [
        'calibration_no',
        'asset_id',
        'checklist_name',
        'standard_reference',
        'scheduled_at',
        'performed_at',
        'next_due_at',
        'status',
        'result',
        'note',
    ];
}
