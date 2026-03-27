<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RcaCapaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rcaCapaId = $this->route('rca_capa')?->id;

        return [
            'rca_no' => 'required|string|max:255|unique:rca_capas,rca_no,'.$rcaCapaId,
            'work_order_id' => 'nullable|exists:work_orders,id',
            'problem_statement' => 'required|string',
            'root_cause' => 'required|string',
            'corrective_action' => 'nullable|string',
            'preventive_action' => 'nullable|string',
            'owner_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'status' => 'required|in:open,in_progress,verified,closed',
        ];
    }
}
