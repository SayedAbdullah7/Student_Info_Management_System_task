<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $id = $this->route('id'); // Get the ID from the route parameters

        return [
            'full_name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:students,code,' . $id,
            'date_of_birth' => 'required|date',
            'email' => 'required|email|max:255|unique:students,email,' . $id,
            'level_id' => 'required|exists:levels,id',
        ];
    }
}
