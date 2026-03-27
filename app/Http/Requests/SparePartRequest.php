<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SparePartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sparePartId = $this->route('spare_part')?->id;

        return [
            'spare_part_category_id' => 'required|exists:spare_part_categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'part_code' => 'required|string|max:255|unique:spare_parts,part_code,'.$sparePartId,
            'part_name' => 'required|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'specification' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'criticality_level' => 'required|in:low,medium,high,critical',
            'min_stock' => 'required|numeric|min:0',
            'max_stock' => 'required|numeric|min:0',
            'reorder_point' => 'required|numeric|min:0',
            'lead_time_days' => 'nullable|integer|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'active' => 'required|boolean',
            'notes' => 'nullable|string',
        ];
    }
}
