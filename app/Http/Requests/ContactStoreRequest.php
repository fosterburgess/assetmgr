<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'max:255', 'string'],
            'mobile' => ['nullable', 'max:255', 'string'],
            'notes' => ['nullable', 'max:255', 'string'],
            'avatar' => ['image', 'max:1024', 'nullable'],
        ];
    }
}