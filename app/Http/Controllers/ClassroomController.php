<?php

namespace App\Http\Controllers;

use App\Enums\AcademicYearStatus;
use App\Http\Requests\StoreClassroomRequest;
use App\Models\AcademicYear;
use App\Models\Classroom;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ClassroomController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(AcademicYear $academicYear): View
    {
        $this->authorize('viewAny', Classroom::class);

        $classrooms = Classroom::where('academic_year_id', $academicYear->id)
            ->withCount(['students', 'teachers'])
            ->with('user')->orderBy('name')->get();

        return view('classrooms.index', [
            'academicYear' => $academicYear,
            'classrooms' => $classrooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(AcademicYear $academicYear): View
    {
        $this->authorize('create', Classroom::class);

        abort_if($academicYear->status === AcademicYearStatus::ARCHIVED, 403, 'Année scolaire archivée : ajout de classes impossible');

        return view('classrooms.edit', [
            'academicYear' => $academicYear,
            'classroom' => new Classroom,
            'pageTitle' => 'Ajouter une classe',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicYear $academicYear, StoreClassroomRequest $request): RedirectResponse
    {
        try {
            $classroom = Classroom::create($request->validated() + ['academic_year_id' => $academicYear->id]);

            return redirect()->route('academic-years.classrooms.index', $academicYear)->with('success', "$classroom->name créée");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, classe non créée')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicYear $academicYear, Classroom $classroom): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academicYear, Classroom $classroom): View
    {
        $this->authorize('update', $classroom);

        return view('classrooms.edit', [
            'academicYear' => $academicYear,
            'classroom' => $classroom,
            'pageTitle' => 'Modifier classe '.$classroom->name.' ('.$classroom->short_name.')',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicYear $academicYear, StoreClassroomRequest $request, Classroom $classroom): RedirectResponse
    {
        try {
            $classroom->fill($request->validated());
            $classroom->save();

            return redirect()->route('academic-years.classrooms.index', $academicYear)->with('success', "$classroom->name modifiée");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, classe non modifié')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear, Classroom $classroom): RedirectResponse
    {
        $this->authorize('delete', $classroom);

        abort_if($academicYear->status === AcademicYearStatus::ARCHIVED, 403, 'Année scolaire archivée : suppression impossible');
        try {
            $classroom->delete();

            return redirect()->route('academic-years.classrooms.index', $academicYear)->with('success', "$classroom->name supprimée");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Error, classe non supprimée')->withInput();
        }
    }
}
