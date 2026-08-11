<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\AcademicYear;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Repositories\AssignmentRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    use AuthorizesRequests;

    private AssignmentRepository$assignmentRepository;

    public function __construct(AssignmentRepository $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Classroom $classroom): View
    {
        $this->authorize('viewAny', [Assignment::class, $classroom]);
        
        $assignments = $this->assignmentRepository->getAssignments($classroom, $request->all());

        $academicYear = AcademicYear::findOrFail($classroom->academic_year_id);

        return view('assignments.index', [
            'academicYear' => $academicYear,
            'classroom' => $classroom,
            'assignments' => $assignments,
            'role' => $request->query('role', '')
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
    public function store(StoreAssignmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        //
    }
}
