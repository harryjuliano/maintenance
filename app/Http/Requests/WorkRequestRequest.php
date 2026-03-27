<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $workRequestId = $this->route('work_request')?->id ?? $this->route('breakdown')?->id;

        return [
            'request_no' => 'required|string|max:255|unique:work_requests,request_no,'.$workRequestId,
            'request_date' => 'required|date',
            'department' => 'nullable|string|max:255',
            'request_type' => 'nullable|in:breakdown,abnormality,inspection_followup,utility,facility,improvement',
            'urgency_level' => 'required|in:low,medium,high,emergency',
            'impact_level' => 'required|in:low,medium,high,critical',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'symptom' => 'nullable|string',
            'asset_id' => 'nullable|exists:assets,id',
            'breakdown_start_at' => 'nullable|date',
            'affects_production' => 'nullable|boolean',
            'estimated_production_loss' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,submitted,reviewed,approved,rejected,converted,closed',
        ];
    }
}
