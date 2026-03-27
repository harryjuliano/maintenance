<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'module' => 'required|string|max:255',
            'reference_id' => 'nullable|integer|min:1',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'channel' => 'required|in:in_app,email,whatsapp',
            'read_at' => 'nullable|date',
        ];
    }
}
