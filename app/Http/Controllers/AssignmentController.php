<?php

namespace App\Http\Controllers;

use App\Enums\AcademicYearStatus;
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\AcademicYear;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Classroom $classroom): View
    {
        $this->authorize('viewAny', [Assignment::class, $classroom]);

        // 1. On récupère le rôle avec 'STUDENT' comme valeur par défaut
        $role = $request->query('role', 'STUDENT');

        $academicYear = AcademicYear::findOrFail($classroom->academic_year_id);

        // 2. Traitement selon le rôle
        if ($role === 'TEACHER') {
            $assignments = Assignment::where('classroom_id', $classroom->id)
                ->whereHas('user', fn ($q) => $q->where('role', 'TEACHER'))
                ->with(['user', 'subject'])
                ->get()
                ->sortBy('user.last_name');

            return view('assignments.teachers', [
                'academicYear' => $academicYear,
                'classroom' => $classroom,
                'assignments' => $assignments,
            ]);
        }

        // Vue élèves par défaut
        $assignments = Assignment::where('classroom_id', $classroom->id)
            ->whereHas('user', fn ($q) => $q->where('role', 'STUDENT'))
            ->with('user')
            ->get()
            ->sortBy('user.last_name');

        return view('assignments.students', [
            'academicYear' => $academicYear,
            'classroom' => $classroom,
            'assignments' => $assignments,
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
    public function show(Assignment $assignment):void
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
    public function destroy(Classroom $classroom, Assignment $assignment): RedirectResponse
    {
        $this->authorize('delete', $assignment);
        $academicYear = AcademicYear::findOrFail($classroom->academic_year_id);
        $user = User::findOrfail($assignment->user_id);

        abort_if($academicYear->status === AcademicYearStatus::ARCHIVED, 403, 'Année scolaire archivée : suppression impossible');
        try {
            $assignment->delete();

            return redirect()->route('assignments.index', ['classroom' => $classroom, 'role' => $user->role])->with('success', "$user->full_name retiré de la classe $classroom->name");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Error, affectation non supprimée')->withInput();
        }
    }
}
