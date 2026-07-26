<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function edit()
    {
        $school = School::firstOrCreate([], [
            'name' => 'Mon École',
            'country_id' => 'FR'
        ]);

        return view('school.edit', [
            'school' => $school
        ]);
    }

    public function update(Request $request)
    {
        $school = School::firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            // tes autres règles de validation...
        ]);

        $school->update($validated);

        return back()->with('success', 'Les informations de l\'école ont été mises à jour.');
    }
}
