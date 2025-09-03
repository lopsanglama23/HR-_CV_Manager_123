<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function allAssignments(): View
    {
        $assignments = Assignment::with('candidate')->get();
        return view('assignments.all', compact('assignments'));
    }

    public function index(Candidate $candidate): View
    {
        $assignments = $candidate->assignments()->get();
        return view('assignments.index', compact('candidate', 'assignments'));
    }

    public function create(Candidate $candidate): View
    {
        return view('assignments.create', compact('candidate'));
    }

    public function store(Request $request, Candidate $candidate): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file',
            'due_date' => 'nullable|date',
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('assignments');
            $data['attachment_path'] = $path;
        }

        $data['candidate_id'] = $candidate->id;
        $data['status'] = 'pending';

        Assignment::create($data);

        return redirect()->route('assignments.candidate.index', $candidate)->with('status', 'Assignment created successfully.');
    }

    public function show(Candidate $candidate, Assignment $assignment): View
    {
        return view('assignments.show', compact('candidate', 'assignment'));
    }

    public function edit(Candidate $candidate, Assignment $assignment): View
    {
        return view('assignments.edit', compact('candidate', 'assignment'));
    }

    public function update(Request $request, Candidate $candidate, Assignment $assignment): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,submitted,evaluated',
            'remarks' => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('assignments');
            $data['attachment_path'] = $path;
        }

        $assignment->update($data);

        return redirect()->route('assignments.show', [$candidate, $assignment])->with('status', 'Assignment updated successfully.');
    }

    public function submit(Request $request, Candidate $candidate, Assignment $assignment): RedirectResponse
    {
        $data = $request->validate([
            'submission' => 'required|file',
            'remarks' => 'nullable|string',
        ]);

        $path = $request->file('submission')->store('assignment_submissions');
        $assignment->update([
            'submission_path' => $path,
            'submitted_at' => now(),
            'status' => 'submitted',
            'remarks' => $data['remarks'] ?? null,
        ]);

        return redirect()->route('assignments.show', [$candidate, $assignment])->with('status', 'Assignment submitted successfully.');
    }
}
