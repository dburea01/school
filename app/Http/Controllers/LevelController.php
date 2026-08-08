<?php

namespace App\Http\Controllers;

use App\Enums\AcademicYearStatus;
use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use App\Models\AcademicYear;
use App\Models\Level;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class LevelController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(AcademicYear $academicYear)
    {
        $this->authorize('viewAny', Level::class);

        $levels = Level::where('academic_year_id', $academicYear->id)->orderBy('position')->get();

        return view('levels.index', [
            'academicYear' => $academicYear,
            'levels' => $levels
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLevelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLevelRequest $request, Level $level)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear, Level $level)
    {
        $this->authorize('delete', $level);

        abort_if($academicYear->status === AcademicYearStatus::ARCHIVED, 422, 'Année scolaire archivée : suppression impossible' );
        try {
            $level->delete();

            return redirect()->route('academic-years.levels.index', $academicYear)->with('success', "$level->name supprimé");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Error, niveau non supprimé')->withInput();
        }
    }
}
