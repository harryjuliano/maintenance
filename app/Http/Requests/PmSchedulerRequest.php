<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PmSchedulerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'template_id' => 'required|exists:preventive_maintenance_templates,id',
            'asset_id' => 'required|exists:assets,id',
            'schedule_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:schedule_date',
            'meter_due' => 'nullable|numeric|min:0',
            'status' => 'required|in:planned,generated,in_progress,done,overdue,skipped,rescheduled',
            'reschedule_reason' => 'nullable|string',
            'completed_at' => 'nullable|date',
        ];
    }
}
