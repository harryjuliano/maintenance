<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvancedReportingAnalyticRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $analyticId = $this->route('advanced_reporting_analytic')?->id;

        return [
            'analytics_no' => 'required|string|max:255|unique:advanced_reporting_analytics,analytics_no,'.$analyticId,
            'report_title' => 'required|string|max:255',
            'report_period' => 'required|date',
            'metric_category' => 'required|in:reliability,cost,energy,sparepart,executive',
            'insight_summary' => 'required|string',
            'anomaly_count' => 'required|integer|min:0',
            'prediction_accuracy' => 'required|numeric|min:0|max:100',
            'recommended_action' => 'nullable|string',
            'prepared_by' => 'nullable|exists:users,id',
            'status' => 'required|in:draft,published,archived',
        ];
    }
}
