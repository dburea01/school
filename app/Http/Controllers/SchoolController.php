<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSchoolRequest;
use App\Models\School;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SchoolController extends Controller
{
    use AuthorizesRequests;

    public function edit(): View
    {
        $this->authorize('update', School::class);

        $school = School::firstOrCreate([], [
            'name' => 'Mon école',
            'country_id' => 'FR',
        ]);

        return view('school.edit', [
            'school' => $school,
        ]);
    }

    public function update(UpdateSchoolRequest $request): RedirectResponse
    {
        $school = School::firstOrFail();

        $school->update($request->validated());

        return back()->with('success', 'Les informations de l\'école ont été mises à jour.');
    }
}
