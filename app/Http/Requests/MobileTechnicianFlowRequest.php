<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MobileTechnicianFlowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mobileTechnicianFlowId = $this->route('mobile_technician_flow')?->id;

        return [
            'flow_no' => 'required|string|max:255|unique:mobile_technician_flows,flow_no,'.$mobileTechnicianFlowId,
            'work_order_id' => 'nullable|exists:work_orders,id',
            'technician_id' => 'nullable|exists:users,id',
            'checkin_at' => 'nullable|date',
            'checkout_at' => 'nullable|date|after_or_equal:checkin_at',
            'action_taken' => 'required|string',
            'sparepart_used' => 'nullable|string',
            'verification_note' => 'nullable|string',
            'status' => 'required|in:assigned,on_the_way,on_site,working,completed,verified',
        ];
    }
}
