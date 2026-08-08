<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Level;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class SchoolStructureController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', Level::class);
        
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->withCount('levels')->get();

        return view('structure.index', [
            'academicYears' => $academicYears,
        ]);
    }
}
