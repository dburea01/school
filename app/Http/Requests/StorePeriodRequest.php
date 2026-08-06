<?php

namespace App\Http\Requests;

use App\Enums\PeriodStatus;
use App\Models\AcademicYear;
use App\Models\Period;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePeriodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user() && $this->method() == 'POST') {
            return $this->user()->can('create', Period::class);
        }

        if ($this->user() && $this->method() == 'PUT') {
            return $this->user()->can('update', $this->route('period'));
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
        /** @var AcademicYear $academicYear */
        $academicYear = $this->route('academic_year');

        $yearStart = $academicYear->start_date->format('d/m/Y');
        $yearEnd = $academicYear->end_date->format('d/m/Y');

        return [
            'status' => ['required', Rule::enum(PeriodStatus::class)],
            'name' => 'required|max:30',
            'short_name' => 'required|max:5',
            'position' => 'required|int|between:1,100',
            'start_date' => [
                'required',
                Rule::date()->format('d/m/Y'),
                "after_or_equal:{$yearStart}",
                "before_or_equal:{$yearEnd}",
            ],
            'end_date' => [
                'required',
                Rule::date()->format('d/m/Y')->after('start_date'),
                "before_or_equal:{$yearEnd}",
            ],
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

            'position.required' => 'Position de la période obligatoire',
            'position.int' => 'Position doit être un entier entre 1 et 100',
            'position.between' => 'Position doit être un entier entre 1 et 100',

            'status.required' => 'Status obligatoire',
            'status.enum' => 'Status inconnu',

            'start_date.required' => 'Date de début obligatoire',
            'start_date.date_format' => 'La date de début doit être au format jj/mm/aaaa',
            'start_date.after_or_equal' => 'La date de début doit être comprise dans l\'année scolaire.',
            'start_date.before_or_equal' => 'La date de début ne peut pas dépasser la fin de l\'année scolaire.',

            'end_date.required' => 'Date de fin obligatoire',
            'end_date.date_format' => 'La date de fin doit être au format jj/mm/aaaa',
            'end_date.after' => 'La date de fin doit être supérieure à la date de début',

            'end_date.before_or_equal' => 'La date de fin ne peut pas dépasser la fin de l\'année scolaire.',

            'comment.max' => 'Commentaire trop long (300 caractères maximum)',
        ];
    }
}
