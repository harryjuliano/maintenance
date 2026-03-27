<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalibrationSupportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $calibrationSupportId = $this->route('calibration_support')?->id;

        return [
            'calibration_no' => 'required|string|max:255|unique:calibration_supports,calibration_no,'.$calibrationSupportId,
            'asset_id' => 'nullable|exists:assets,id',
            'checklist_name' => 'required|string|max:255',
            'standard_reference' => 'nullable|string|max:255',
            'scheduled_at' => 'required|date',
            'performed_at' => 'nullable|date',
            'next_due_at' => 'nullable|date|after_or_equal:scheduled_at',
            'status' => 'required|in:planned,in_progress,completed,overdue,cancelled',
            'result' => 'required|in:pending,pass,fail',
            'note' => 'nullable|string',
        ];
    }
}
