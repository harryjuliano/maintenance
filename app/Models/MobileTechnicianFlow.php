<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileTechnicianFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'flow_no',
        'work_order_id',
        'technician_id',
        'checkin_at',
        'checkout_at',
        'action_taken',
        'sparepart_used',
        'verification_note',
        'status',
    ];
}
