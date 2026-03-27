<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperationalReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $reportId = $this->route('operational_report')?->id;

        return [
            'report_no' => 'required|string|max:255|unique:operational_reports,report_no,'.$reportId,
            'report_date' => 'required|date',
            'shift' => 'required|in:shift_1,shift_2,shift_3,general',
            'summary' => 'required|string',
            'downtime_minutes' => 'required|integer|min:0',
            'breakdown_count' => 'required|integer|min:0',
            'pm_compliance' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:draft,submitted,approved',
            'prepared_by' => 'nullable|exists:users,id',
        ];
    }
}
