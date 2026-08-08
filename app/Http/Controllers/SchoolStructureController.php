<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\View\View;

class SchoolStructureController extends Controller
{
    public function index(): View
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->withCount('levels')->get();

        return view('structure.index', [
            'academicYears' => $academicYears,
        ]);
    }
}
