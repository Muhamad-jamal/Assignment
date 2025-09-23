<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Employee;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('employees')->ignore($this->employee->id),
            ],
            'position_id' => 'required|exists:positions,id',
            'salary' => 'required|numeric|min:0',
            'manager_id' => 'nullable|exists:employees,id',
            'is_founder' => 'boolean',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $isFounder = $this->input('is_founder', false);

            if ($isFounder) {
                if (Employee::where('is_founder', true)
                    ->where('id', '!=', $this->employee->id)
                    ->exists()
                ) {
                    $validator->errors()->add('is_founder', 'There can only be one founder.');
                }
            } elseif (!$this->input('manager_id')) {
                $validator->errors()->add('manager_id', 'Non-founder employees must have a manager.');
            }
        });
    }
}
