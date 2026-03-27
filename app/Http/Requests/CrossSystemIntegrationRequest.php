<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrossSystemIntegrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $integrationId = $this->route('cross_system_integration')?->id;

        return [
            'integration_no' => 'required|string|max:255|unique:cross_system_integrations,integration_no,'.$integrationId,
            'system_name' => 'required|string|max:255',
            'integration_type' => 'required|in:api,etl,iot,manual',
            'endpoint' => 'nullable|string|max:255',
            'sync_frequency' => 'required|in:realtime,hourly,daily,weekly,on_demand',
            'last_sync_at' => 'nullable|date',
            'success_rate_pct' => 'required|numeric|min:0|max:100',
            'owner_id' => 'nullable|exists:users,id',
            'status' => 'required|in:planned,active,issue,deprecated',
            'note' => 'nullable|string',
        ];
    }
}
