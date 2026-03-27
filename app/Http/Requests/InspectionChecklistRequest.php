<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InspectionChecklistRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $inspectionChecklistId = $this->route('inspection_checklist')?->id;

        return [
            'asset_id' => 'nullable|exists:assets,id',
            'inspection_type' => 'required|in:daily_check,autonomous_maintenance,utility_check,safety_check,facility_check',
            'code' => 'required|string|max:255|unique:inspection_templates,code,'.$inspectionChecklistId,
            'name' => 'required|string|max:255',
            'frequency_unit' => 'required|in:day,week,month',
            'frequency_value' => 'required|integer|min:1',
            'active' => 'nullable|boolean',
        ];
    }
}
