<?php

namespace App\Http\Requests;

use App\Enums\AcademicYearStatus;
use App\Models\AcademicYear;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreAcademicYearRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user() && $this->method() == 'POST') {
            return $this->user()->can('create', AcademicYear::class);
        }

        if ($this->user() && $this->method() == 'PUT') {
            return $this->user()->can('update', $this->route('academic_year'));
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
            'status' => ['required', Rule::enum(AcademicYearStatus::class)],
            'start_date' => [
                'required',
                Rule::date()->format('d/m/Y'),
            ],
            'end_date' => [
                'required',
                Rule::date()->format('d/m/Y')->after('start_date'),
            ],
            'comment' => 'nullable|max:300',
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                // 1. On ne contrôle QUE si l'utilisateur essaie de passer l'année au statut CURRENT
                if ($this->input('status') !== AcademicYearStatus::CURRENT->value) {
                    return;
                }

                // 2. On récupère l'instance ou l'UUID de l'année (null si on est en création)
                /** @var AcademicYear|string|null $routeParam */
                $routeParam = $this->route('academic_year');
                $currentId = $routeParam instanceof AcademicYear ? $routeParam->id : $routeParam;

                // 3. On vérifie s'il existe UNE AUTRE année courante en BDD
                $hasAnotherCurrentYear = AcademicYear::query()
                    ->when($currentId, fn ($query) => $query->where('id', '<>', $currentId))
                    ->where('status', AcademicYearStatus::CURRENT)
                    ->exists();

                if ($hasAnotherCurrentYear) {
                    $validator->errors()->add(
                        'status',
                        'Il ne peut y avoir qu\'une seule année courante à la fois. Veuillez d\'abord modifier le statut de l\'année courante actuelle.'
                    );
                }
            },
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

            'status.required' => 'Status obligatoire',
            'status.enum' => 'Status inconnu',

            'start_date.required' => 'Date de début obligatoire',
            'start_date.date_format' => 'La date de début doit être au format jj/mm/aaaa',

            'end_date.required' => 'Date de fin obligatoire',
            'end_date.date_format' => 'La date de fin doit être au format jj/mm/aaaa',
            'end_date.after' => 'La date de fin doit être supérieure à la date de début',

            'comment.max' => 'Commentaire trop long (300 caractères maximum)',
        ];
    }
}
