<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Models\Subject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SubjectController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Subject::class);

        $subjects = Subject::orderBy('short_name')->get();

        return view('subjects.index', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Subject::class);

        $subject = new Subject;
        $subject->is_active = true;
        $subject->color = '#FFFFFF';

        return view('subjects.edit', [
            'subject' => $subject,
            'pageTitle' => 'Créer matière',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request): RedirectResponse
    {
        try {
            $subject = Subject::create($request->validated());

            return redirect()->route('subjects.index')->with('success', "$subject->name créée");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, matière non créée')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject): View
    {
        $this->authorize('update', $subject);

        return view('subjects.edit', [
            'subject' => $subject,
            'pageTitle' => 'Modifier matière',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSubjectRequest $request, Subject $subject): RedirectResponse
    {
        try {
            $subject->fill($request->validated());
            $subject->save();

            return redirect()->route('subjects.index')->with('success', "$subject->name modifiée");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Erreur, métière non modifiée')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject): RedirectResponse
    {
        $this->authorize('delete', $subject);

        try {
            $subject->delete();

            return redirect()->route('subjects.index')->with('success', "$subject->name supprimé");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Error, matière non supprimée')->withInput();
        }
    }
}
