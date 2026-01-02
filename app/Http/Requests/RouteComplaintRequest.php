<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only allow users with Admin or Super Admin role to process this request
        // The middleware already handles the role check, but this adds another layer.
        return auth()->user()->hasRole(\App\Enums\Roles::ADMIN) || auth()->user()->hasRole(\App\Enums\Roles::SUPER_ADMIN);
    }

    public function rules(): array
    {
        return [
            // The office where the admin decides the complaint should be addressed
            'assigned_office_id' => ['required', 'integer', 'exists:offices,id'],

            // Optional remarks by the admin for the handling office
            'admin_remarks' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'assigned_office_id.required' => 'You must select an office to assign this complaint to.',
        ];
    }
}
