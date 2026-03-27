<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $workOrderId = $this->route('work_order')?->id;

        return [
            'work_order_no' => 'required|string|max:255|unique:work_orders,work_order_no,'. $workOrderId,
            'work_request_id' => 'nullable|exists:work_requests,id',
            'asset_id' => 'required|exists:assets,id',
            'work_order_type' => 'required|in:corrective,preventive,predictive,inspection,calibration,improvement,emergency',
            'priority_level' => 'required|in:low,medium,high,critical',
            'maintenance_class' => 'required|in:planned,unplanned',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,planned,assigned,in_progress,waiting_sparepart,waiting_production_release,completed,verified,closed,cancelled',
        ];
    }
}
