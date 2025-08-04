<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sale_date' => ['required'],
            'amount' => ['required'],
            'target_amount' => ['required'],
        ];
    }

    public function messages(): array {
        return [
            'sale_date.required' => 'The sale date field is required',
            'amount.required' => 'The amount field is required',
            'target_amount' => 'The target amount field is required'
        ];
    }
}
