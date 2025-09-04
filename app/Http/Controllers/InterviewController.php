<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Interview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InterviewScheduled;
use App\Mail\InterviewRejection;

class InterviewController extends Controller
{
	public function index(Candidate $candidate)
	{
		return view('candidates.interviews', compact('candidate'));
	}

	public function store(Request $request, Candidate $candidate): RedirectResponse
	{
		$data = $request->validate([
			'round' => ['required', 'in:first,second,third'],
			'scheduled_at' => ['required', 'date', 'after:now'],
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
				Mail::to($candidate->email)->send(new InterviewScheduled($interview));
			} catch (\Exception $e) {
				// Log the error but don't fail the scheduling
				\Log::error('Failed to send interview scheduling email: ' . $e->getMessage());
			}
		}

		// Send reminder email to interviewer
		if ($interview->interviewer_email) {
			try {
				Mail::to($interview->interviewer_email)->send(new \App\Mail\InterviewReminder($interview));
			} catch (\Exception $e) {
				// Log the error but don't fail the scheduling
				\Log::error('Failed to send interview reminder email: ' . $e->getMessage());
			}
		}

		return back()->with('status', 'Interview scheduled');
	}

	public function update(Request $request, Candidate $candidate, Interview $interview): RedirectResponse
	{
		$data = $request->validate([
			'scheduled_at' => ['sometimes', 'date', 'after:now'],
			'interviewer_name' => ['nullable', 'string', 'max:255'],
			'interviewer_email' => ['nullable', 'email'],
			'remarks' => ['nullable', 'string'],
			'result' => ['nullable', 'in:pending,pass,fail'],
		]);
		$interview->update($data);

		// Update candidate status based on interview round and result
		if ($data['result'] === 'pass') {
			if ($interview->round === 'first' && $candidate->status !== 'first_interview') {
				$candidate->status = 'first_interview';
				$candidate->save();
			} elseif ($interview->round === 'second' && $candidate->status !== 'second_interview') {
				$candidate->status = 'second_interview';
				$candidate->save();
			} elseif ($interview->round === 'third' && $candidate->status !== 'third_interview') {
				$candidate->status = 'third_interview';
				$candidate->save();
			}

			// Send acceptance email for passed interviews
			if ($interview->candidate->email) {
				try {
					// We'll create a new mail class for interview acceptance
					Mail::to($interview->candidate->email)->send(new \App\Mail\InterviewAcceptance($interview));
				} catch (\Exception $e) {
					\Log::error('Failed to send interview acceptance email: ' . $e->getMessage());
				}
			}
		}

		// Send rejection email if interview failed
		if ($data['result'] === 'fail' && $interview->candidate->email) {
			try {
				Mail::to($interview->candidate->email)->send(new InterviewRejection($interview));
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
