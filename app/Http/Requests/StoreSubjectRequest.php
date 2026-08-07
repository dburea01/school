<?php

namespace App\Http\Requests;

use App\Models\Subject;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user() && $this->method() == 'POST') {
            return $this->user()->can('create', Subject::class);
        }

        if ($this->user() && $this->method() == 'PUT') {
            return $this->user()->can('update', $this->route('subject'));
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
            'is_active' => 'required|boolean',
            'name' => 'required|max:30',
            'short_name' => 'required|max:10',
            'color' => 'nullable|hex_color',
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
            'is_active.required' => 'Matière active ou pas ? obligatoire',
            'is_active.boolean' => 'Matière active ? non valide',

            'name.required' => 'Nom obligatoire',
            'name.max' => 'Nom trop long (50 caractères max)',

            'short_name.required' => 'Nom court obligatoire',
            'short_name.max' => 'Nom court trop long (10 caractères max)',

            'color.hex_color' => 'Couleur incorrecte',

            'comment.max' => 'commentaire trop long (300 caractères max)',
        ];
    }
}
