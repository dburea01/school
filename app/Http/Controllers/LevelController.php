<?php

namespace App\Http\Controllers;

use App\Enums\AcademicYearStatus;
use App\Http\Requests\StoreLevelRequest;
use App\Models\AcademicYear;
use App\Models\Level;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LevelController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(AcademicYear $academicYear): View
    {
        $this->authorize('viewAny', Level::class);

        $levels = Level::where('academic_year_id', $academicYear->id)->orderBy('position')->get();

        return view('levels.index', [
            'academicYear' => $academicYear,
            'levels' => $levels,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(AcademicYear $academicYear): View
    {
        $this->authorize('create', Level::class);

        abort_if($academicYear->status === AcademicYearStatus::ARCHIVED, 403, 'Année scolaire archivée : ajout de niveaux impossible');

        return view('levels.edit', [
            'academicYear' => $academicYear,
            'level' => new Level,
            'pageTitle' => 'Ajouter un niveau',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicYear $academicYear, StoreLevelRequest $request): RedirectResponse
    {
        try {
            $level = Level::create($request->validated() + ['academic_year_id' => $academicYear->id]);

            return redirect()->route('academic-years.levels.index', $academicYear)->with('success', "$level->name créé");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, niveau non créé')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academicYear, Level $level): View
    {
        $this->authorize('update', $level);

        return view('levels.edit', [
            'academicYear' => $academicYear,
            'level' => $level,
            'pageTitle' => 'Modifier niveau '.$level->name.' ('.$level->short_name.')',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicYear $academicYear, StoreLevelRequest $request, Level $level): RedirectResponse
    {
        try {
            $level->fill($request->validated());
            $level->save();

            return redirect()->route('academic-years.levels.index', $academicYear)->with('success', "$level->name modifié");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, niveau non modifié')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear, Level $level): RedirectResponse
    {
        $this->authorize('delete', $level);

        abort_if($academicYear->status === AcademicYearStatus::ARCHIVED, 403, 'Année scolaire archivée : suppression impossible');
        try {
            $level->delete();

            return redirect()->route('academic-years.levels.index', $academicYear)->with('success', "$level->name supprimé");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Error, niveau non supprimé')->withInput();
        }
    }
}
