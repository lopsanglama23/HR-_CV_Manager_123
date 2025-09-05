<?php

namespace App\Http\Controllers;

use App\Mail\AssessmentNotification;
use App\Models\Assessment;
use App\Models\Candidate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AssessmentController extends Controller
{
	public function store(Request $request, Candidate $candidate): RedirectResponse
	{
		$data = $request->validate([
			'title' => ['required', 'string', 'max:255'],
			'type' => ['nullable', 'in:behavioral,test'],
			'remarks' => ['nullable', 'string'],
			'score' => ['nullable', 'integer', 'between:0,100'],
			'attachment' => ['nullable', 'file', 'max:10240'],
		]);
		$data['candidate_id'] = $candidate->id;
		if ($request->hasFile('attachment')) {
			$data['attachment_path'] = $request->file('attachment')->store('assessments', 'public');
		}
		$assessment = Assessment::create($data);

		// Send email notification to candidate
		if ($candidate->email) {
			Mail::to($candidate->email)->send(new AssessmentNotification($assessment));
		}

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


