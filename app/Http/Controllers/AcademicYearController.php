<?php

namespace App\Http\Controllers;

use App\Enums\AcademicYearStatus;
use App\Http\Requests\StoreAcademicYearRequest;
use App\Models\AcademicYear;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class AcademicYearController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', AcademicYear::class);

        $academicYears = AcademicYear::with(['periods' => function ($query) {
            $query->orderBy('position');
        }])->orderBy('start_date', 'desc')->get();

        return view('academic-years.index', [
            'academicYears' => $academicYears,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', AcademicYear::class);

        $academicYear = new AcademicYear;
        // $academicYear->status = AcademicYearStatus::DRAFT;

        return view('academic-years.edit', [
            'academicYear' => $academicYear,
            'pageTitle' => 'Créer année scolaire',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademicYearRequest $request): RedirectResponse
    {
        try {
            $academicYear = AcademicYear::create($request->validated());

            return redirect()->route('academic-years.index')->with('success', "$academicYear->name créée");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, année scolaire non créée')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicYear $academicYear): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academicYear): View
    {
        $this->authorize('update', $academicYear);

        return view('academic-years.edit', [
            'academicYear' => $academicYear,
            'pageTitle' => 'Modifier année scolaire',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAcademicYearRequest $request, AcademicYear $academicYear): RedirectResponse
    {
        try {
            $academicYear->fill($request->validated());
            $academicYear->save();

            return redirect()->route('academic-years.index')->with('success', "$academicYear->name modifiée");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, année scolaire non modifiée')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear): RedirectResponse
    {
        $this->authorize('delete', $academicYear);

        try {
            $academicYear->delete();

            return back()->with('success', "$academicYear->name supprimée");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, année scolaire non supprimée')->withInput();
        }
    }
}
