<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DowntimeLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'work_order_id' => 'required|exists:work_orders,id',
            'asset_id' => 'required|exists:assets,id',
            'downtime_start_at' => 'required|date',
            'downtime_end_at' => 'nullable|date|after_or_equal:downtime_start_at',
            'total_minutes' => 'nullable|integer|min:0',
            'downtime_type' => 'required|in:full_stop,partial_stop,reduced_speed,standby_loss',
            'production_impact_note' => 'nullable|string',
            'loss_estimation' => 'nullable|numeric|min:0',
        ];
    }
}
