<?php

namespace App\Repositories;

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AssignmentRepository
{
    /**
     * @param  array<string>  $request
     * @return Collection<int,Assignment>
     */
    public function getAssignments(Classroom $classroom, array $request)
    {
        return Assignment::where('classroom_id', $classroom->id)
        ->with(['user', 'subject'])
        ->when($request['role'] ?? null, function ($q, $role) {
            $q->whereHas('user', function ($userQuery) use ($role) {
                $userQuery->where('role', $role);
            });
        })
        ->get()
        ->sortBy([
            ['user.role', 'desc'],     // 'TEACHER' avant 'STUDENT'
            ['user.last_name', 'asc'], // Ordre alphabétique
        ]);
    }
}
