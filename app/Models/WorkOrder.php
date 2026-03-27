<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'work_order_no',
        'work_request_id',
        'asset_id',
        'area_id',
        'production_line_id',
        'work_order_type',
        'priority_level',
        'maintenance_class',
        'title',
        'description',
        'status',
    ];
}
