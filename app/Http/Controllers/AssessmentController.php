<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Candidate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssessmentController extends Controller
{
	public function store(Request $request, Candidate $candidate): RedirectResponse
	{
		$data = $request->validate([
			'title' => ['required', 'string', 'max:255'],
			'remarks' => ['nullable', 'string'],
			'score' => ['nullable', 'integer', 'between:0,100'],
			'attachment' => ['nullable', 'file', 'max:10240'],
		]);
		$data['candidate_id'] = $candidate->id;
		if ($request->hasFile('attachment')) {
			$data['attachment_path'] = $request->file('attachment')->store('assessments', 'public');
		}
		Assessment::create($data);
		return back()->with('status', 'Assessment saved');
	}

	public function destroy(Candidate $candidate, Assessment $assessment): RedirectResponse
	{
		if ($assessment->attachment_path) {
			Storage::disk('public')->delete($assessment->attachment_path);
		}
		$assessment->delete();
		return back()->with('status', 'Assessment deleted');
	}
}


