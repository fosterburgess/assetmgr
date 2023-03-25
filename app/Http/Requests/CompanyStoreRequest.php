<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
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
            'logo' => ['image', 'max:1024', 'nullable'],
            'address1' => ['nullable', 'max:255', 'string'],
            'address2' => ['nullable', 'max:255', 'string'],
            'city' => ['nullable', 'max:255', 'string'],
            'state' => ['nullable', 'max:255', 'string'],
            'postal_code' => ['nullable', 'max:255', 'string'],
            'url1' => ['nullable', 'max:255', 'string'],
            'url2' => ['nullable', 'max:255', 'string'],
            'url3' => ['nullable', 'max:255', 'string'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'max:255', 'string'],
        ];
    }
}
