<?php

namespace App\Http\Requests;

use App\Models\Classroom;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreClassroomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user() && $this->method() == 'POST') {
            return $this->user()->can('create', Classroom::class);
        }

        if ($this->user() && $this->method() == 'PUT') {
            return $this->user()->can('update', $this->route('classroom'));
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:30',
            'short_name' => 'required|max:5',
            'comment' => 'nullable|max:300',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Nom obligatoire',
            'name.max' => 'Nom trop long (30 caractères max)',

            'short_name.required' => 'Nom court obligatoire',
            'short_name.max' => 'Nom court trop long (5 caractères max)',

            'comment.max' => 'Commentaire trop long (300 caractères maximum)',
        ];
    }
}
