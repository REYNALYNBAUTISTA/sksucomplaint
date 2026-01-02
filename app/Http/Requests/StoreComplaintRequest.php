<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Office;

class StoreComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only authenticated users (who have passed the role middleware) can submit complaints.
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            // Subject must be present and under 255 chars
            'subject' => ['required', 'string', 'max:255'],

            // Description must be present and at least 20 chars long
            'description' => ['required', 'string', 'min:20'],

            // target_office_id must exist in the 'offices' table
            'target_office_id' => ['required', 'integer', 'exists:offices,id'],

            // File upload rules: Optional, image/PDF only, max size 2MB (2048 KB)
            'file_upload' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'],
        ];
    }

    // Custom messages for clarity
    public function messages(): array
    {
        return [
            'target_office_id.exists' => 'Please select a valid Office from the list.',
            'file_upload.mimes' => 'The uploaded file must be a JPG, PNG, or PDF.',
        ];
    }
}
