<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Interview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
	public function store(Request $request, Candidate $candidate): RedirectResponse
	{
		$data = $request->validate([
			'round' => ['required', 'in:first,second,third'],
			'scheduled_at' => ['required', 'date'],
			'interviewer' => ['required', 'string'],
			'remarks' => ['nullable', 'string'],
		]);
		$interviewerParts = explode('|', $request->interviewer);
		$data['interviewer_name'] = $interviewerParts[0];
		$data['interviewer_email'] = $interviewerParts[1];
		$data['candidate_id'] = $candidate->id;
		$interview = Interview::create($data);

		// Send email notification to candidate
		if ($candidate->email) {
			try {
				\Mail::to($candidate->email)->send(new \App\Mail\InterviewScheduled($interview));
			} catch (\Exception $e) {
				// Log the error but don't fail the scheduling
				\Log::error('Failed to send interview scheduling email: ' . $e->getMessage());
			}
		}

		return back()->with('status', 'Interview scheduled');
	}

	public function update(Request $request, Candidate $candidate, Interview $interview): RedirectResponse
	{
		$data = $request->validate([
			'scheduled_at' => ['sometimes', 'date'],
			'interviewer_name' => ['nullable', 'string', 'max:255'],
			'interviewer_email' => ['nullable', 'email'],
			'remarks' => ['nullable', 'string'],
			'result' => ['nullable', 'in:pending,pass,fail'],
		]);
		$interview->update($data);

		// Send rejection email if second interview failed
		if ($interview->round === 'second' && $data['result'] === 'fail' && $interview->candidate->email) {
			try {
				\Mail::to($interview->candidate->email)->send(new \App\Mail\InterviewRejection($interview));
			} catch (\Exception $e) {
				\Log::error('Failed to send rejection email: ' . $e->getMessage());
			}
		}

		return back()->with('status', 'Interview updated');
	}

	public function destroy(Candidate $candidate, Interview $interview): RedirectResponse
	{
		$interview->delete();
		return back()->with('status', 'Interview deleted');
	}
}


