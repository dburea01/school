<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContactAuthorRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:60',
            'email' => 'required|email',
            'message' => 'required|min:10|max:1000',
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
            'name.required' => 'Votre nom est obligatoire',
            'email.required' => 'Votre adresse email est obligatoire',
            'email.email' => 'Adresse email non valide',
            'message.required' => 'Message obligatoire',
            'message.min' => 'Message trop court',
            'message.max' => 'Message trop long'
        ];
    }
}
