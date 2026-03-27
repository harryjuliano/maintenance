<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrossSystemIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'integration_no',
        'system_name',
        'integration_type',
        'endpoint',
        'sync_frequency',
        'last_sync_at',
        'success_rate_pct',
        'owner_id',
        'status',
        'note',
    ];
}
