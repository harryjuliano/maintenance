<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvancedReportingAnalytic extends Model
{
    use HasFactory;

    protected $table = 'advanced_reporting_analytics';

    protected $fillable = [
        'analytics_no',
        'report_title',
        'report_period',
        'metric_category',
        'insight_summary',
        'anomaly_count',
        'prediction_accuracy',
        'recommended_action',
        'prepared_by',
        'status',
    ];
}
