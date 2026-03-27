<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $assetId = $this->route('asset')?->id;

        return [
            'asset_code' => 'required|string|max:255|unique:assets,asset_code,'. $assetId,
            'asset_name' => 'required|string|max:255',
            'asset_number' => 'required|string|max:255|unique:assets,asset_number,'. $assetId,
            'criticality_level' => 'required|in:low,medium,high,critical',
            'maintenance_strategy' => 'required|in:run_to_failure,preventive,predictive,condition_based',
            'status' => 'required|in:active,standby,under_repair,retired',
            'location_note' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }
}
