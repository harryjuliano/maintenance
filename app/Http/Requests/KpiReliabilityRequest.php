<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KpiReliabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kpiReliabilityId = $this->route('kpi_reliability')?->id;

        return [
            'kpi_code' => 'required|string|max:255|unique:kpi_reliabilities,kpi_code,'.$kpiReliabilityId,
            'kpi_period' => 'required|date',
            'asset_id' => 'nullable|exists:assets,id',
            'mtbf_hours' => 'required|numeric|min:0',
            'mttr_hours' => 'required|numeric|min:0',
            'availability_pct' => 'required|numeric|min:0|max:100',
            'breakdown_count' => 'required|integer|min:0',
            'emergency_wo_ratio' => 'required|numeric|min:0|max:100',
            'pm_compliance' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:draft,published',
        ];
    }
}
