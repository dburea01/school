<?php

namespace App\Http\Requests;

use App\Models\School;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $school = School::firstOrFail();

        if ($this->user()) {
            return $this->user()->can('update', $school);
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
            'name' => 'required|max:50',
            'address' => 'nullable|max:100',
            'postal_code' => 'required|digits:5',
            'city' => 'required|max:50',
            'country_id' => 'required|alpha|size:2',
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
            'name.max' => 'Nom trop long (50 caractères max)',

            'address.max' => 'Adresse trop longue (100 caractères max)',

            'postal_code.required' => 'Code postal obligatoire',
            'postal_code.digits' => '5 caractères numériques pour le code postal',

            'city.required' => 'Ville obligatoire',
            'city.max' => 'Ville trop longue (50 caractères max)',

            'country_id.required' => 'Pays obligatoire',
            'country_id.alpha' => 'Pays doit être alphabétique',
            'country_id.size' => 'Pays trop long (2 caractères max)',
        ];
    }
}
