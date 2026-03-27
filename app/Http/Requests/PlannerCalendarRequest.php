<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlannerCalendarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $plannerCalendarId = $this->route('planner_calendar')?->id;

        return [
            'plan_no' => 'required|string|max:255|unique:planner_calendars,plan_no,'.$plannerCalendarId,
            'title' => 'required|string|max:255',
            'plan_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'asset_id' => 'nullable|exists:assets,id',
            'work_order_id' => 'nullable|exists:work_orders,id',
            'assigned_to' => 'nullable|exists:users,id',
            'plan_type' => 'required|in:pm,cm,inspection,calibration,project',
            'priority' => 'required|in:low,medium,high,emergency',
            'status' => 'required|in:scheduled,in_progress,done,cancelled',
            'note' => 'nullable|string',
        ];
    }
}
