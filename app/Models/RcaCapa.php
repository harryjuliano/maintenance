<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RcaCapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'rca_no',
        'work_order_id',
        'problem_statement',
        'root_cause',
        'corrective_action',
        'preventive_action',
        'owner_id',
        'due_date',
        'status',
    ];
}
