<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PredictiveMaintenanceReadinessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $readinessId = $this->route('predictive_maintenance_readiness')?->id;

        return [
            'readiness_no' => 'required|string|max:255|unique:predictive_maintenance_readinesses,readiness_no,'.$readinessId,
            'assessment_date' => 'required|date',
            'asset_id' => 'nullable|exists:assets,id',
            'data_quality_score' => 'required|numeric|min:0|max:100',
            'sensor_coverage_pct' => 'required|numeric|min:0|max:100',
            'failure_model_status' => 'required|in:not_started,training,validated,deployed',
            'readiness_level' => 'required|in:low,medium,high,best_in_class',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,reviewed,approved',
        ];
    }
}
