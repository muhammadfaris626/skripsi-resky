<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
            'employee_number' => [
                'required',
                Rule::unique('employees', 'employee_number')->ignore($this->id)
            ],
            'name' => ['required'],
            'position' => ['required']
        ];
    }

    public function messages(): array {
        return [
            'employee_number.required' => 'The employee number field is required',
            'name.required' => 'The name field is required',
            'position.required' => 'The position field is required'
        ];
    }
}
