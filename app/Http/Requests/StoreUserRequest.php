<?php

namespace App\Http\Requests;

use App\Enums\UserGender;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user() && $this->method() == 'POST') {
            return $this->user()->can('create', User::class);
        }

        if ($this->user() && $this->method() == 'PUT') {
            return $this->user()->can('update', $this->route('user'));
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        return [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:100',
            'role' => ['required', Rule::enum(UserRole::class)],
            'email' => [
                'nullable',
                Rule::unique('users')
                    ->ignore($this->user),
            ],
            'gender' => ['nullable', Rule::enum(UserGender::class)],
            'birth_date' => ['nullable', Rule::date()->format('d/m/Y')->beforeToday()],
            'phone_number' => 'nullable|max:25',
            'address' => 'nullable|max:255',
            'postal_code' => 'nullable|max:5',
            'city' => 'nullable|max:50',
            // 'country' => 'required|size:2',
            'comment' => 'nullable|max:255',
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
            'first_name.required' => 'Prénom obligatoire',
            'first_name.max' => 'Prénom trop long (50 caractères max)',

            'last_name.required' => 'Nom obligatoire',
            'last_name.max' => 'Nom trop long (100 caractères max)',

            'role.required' => 'Rôle obligatoire',
            'role.enum' => 'Rôle inconnu',

            'email.email' => 'Email non valide',
            'email.unique' => 'Email déjà utilisé',
            // 'email.required' => 'Adresse email obligatoire pour autoriser les accés à cet utilisateur.',

            'gender.enum' => 'Genre incorrect',
            'birth_date.date_format' => 'La date de naissance doit être au format jj/mm/aaaa',
            'birth_date.before' => 'La date de naissance doit être dans le passé',

            'address.max' => 'Adresse trop longue (255 caractères max)',
            'postal_code.max' => 'code postal trop long (5 caractères max)',
            'city.max' => 'Commune trop longue (50 caractères max)',
            'country.size' => '2 caractères pour la code pays',

            'comment.max' => 'Commentaire trop long (255 caractères max)',
        ];
    }
}
