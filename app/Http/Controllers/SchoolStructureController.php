<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Classroom;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class SchoolStructureController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', Classroom::class);

        $academicYears = AcademicYear::orderBy('start_date', 'desc')->withCount('classrooms')->get();

        return view('structure.index', [
            'academicYears' => $academicYears,
        ]);
    }
}
