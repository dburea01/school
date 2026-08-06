<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeriodRequest;
use App\Models\AcademicYear;
use App\Models\Period;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PeriodController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(AcademicYear $academicYear): View
    {
        $this->authorize('create', Period::class);

        $period = new Period;

        return view('periods.edit', [
            'academicYear' => $academicYear,
            'period' => $period,
            'pageTitle' => 'Ajouter une période',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicYear $academicYear, StorePeriodRequest $request): RedirectResponse
    {
        try {
            $period = Period::create($request->validated() + ['academic_year_id' => $academicYear->id]);

            return redirect()->route('academic-years.index')->with('success', "$period->name créée");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, période non créée')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Period $period): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academicYear, Period $period): View
    {
        $this->authorize('update', $period);

        return view('periods.edit', [
            'academicYear' => $academicYear,
            'period' => $period,
            'pageTitle' => 'Modifier période '.$period->name.' ('.$period->short_name.')',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePeriodRequest $request, AcademicYear $academicYear, Period $period): RedirectResponse
    {
        try {
            $period->fill($request->validated());
            $period->save();

            return redirect()->route('academic-years.index')->with('success', "$period->name modifiée");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, période non modifiée')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear, Period $period): RedirectResponse
    {
        $this->authorize('delete', $period);

        try {
            $period->delete();

            return redirect()->route('academic-years.index')->with('success', "$period->name supprimée");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Error, période non supprimé')->withInput();
        }
    }
}
