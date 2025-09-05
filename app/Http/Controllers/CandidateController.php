<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CandidateController extends Controller
{
	public function index(Request $request): View
	{
		$query = Candidate::query();
		$search = $request->string('q')->toString();
		$status = $request->string('status')->toString();
		if ($search) {
			$query->where(function ($q) use ($search) {
				$q->where('name', 'like', "%{$search}%")
					->orWhere('technology', 'like', "%{$search}%");
			});
		}
		if ($status) {
			$query->where('status', $status);
		}
		$candidates = $query->latest()->paginate(12)->withQueryString();
		return view('candidates.index', compact('candidates', 'search', 'status'));
	}

	public function create(): View
	{
		return view('candidates.create');
	}

	public function store(Request $request): RedirectResponse
	{
		$data = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'phone' => ['required', 'string', 'max:50'],
			'email' => ['required', 'email'],
			'technology' => ['required', 'string', 'max:100'],
			'level' => ['required', 'in:junior,mid,senior'],
			'salary_expectation' => ['required', 'numeric'],
			'experience_years' => ['required', 'numeric'],
			'references' => ['nullable', 'string'],
			'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
		]);
		if ($request->hasFile('cv')) {
			$data['cv_path'] = $request->file('cv')->store('cvs', 'public');
		}
		$candidate = Candidate::create($data);

		// Send Reference Email
		if ($candidate->references) {
			$referenceEmails = array_map('trim', explode(',', $candidate->references));
			foreach ($referenceEmails as $email) {
				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
					try {
						\Mail::to($email)->send(new \App\Mail\ReferenceEmail($candidate));
					} catch (\Exception $e) {
						\Log::error('Failed to send reference email to ' . $email . ': ' . $e->getMessage());
					}
				}
			}
		}

		return redirect()->route('candidates.show', $candidate)->with('status', 'Candidate created');
	}

	public function show(Candidate $candidate): View
	{
		$candidate->load(['assessments', 'interviews' => function ($q) {
			$q->orderBy('scheduled_at', 'desc');
		}]);
		return view('candidates.show', compact('candidate'));
	}

	public function edit(Candidate $candidate): View
	{
		return view('candidates.edit', compact('candidate'));
	}

	public function update(Request $request, Candidate $candidate): RedirectResponse
	{
		$data = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'phone' => ['nullable', 'string', 'max:50'],
			'email' => ['nullable', 'email'],
			'technology' => ['nullable', 'string', 'max:100'],
			'level' => ['nullable', 'in:junior,mid,senior'],
			'salary_expectation' => ['nullable', 'numeric'],
			'experience_years' => ['nullable', 'numeric'],
			'references' => ['nullable', 'string'],
			'status' => ['required', 'in:shortlisted,first_interview,second_interview,third_interview,hired,rejected,blacklisted'],
			'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
		]);
		if ($request->hasFile('cv')) {
			if ($candidate->cv_path) {
				Storage::disk('public')->delete($candidate->cv_path);
			}
			$data['cv_path'] = $request->file('cv')->store('cvs', 'public');
		}
		$candidate->update($data);
		return redirect()->route('candidates.show', $candidate)->with('status', 'Candidate updated');
	}

	public function destroy(Candidate $candidate): RedirectResponse
	{
		if ($candidate->cv_path) {
			Storage::disk('public')->delete($candidate->cv_path);
		}
		$candidate->delete();
		return redirect()->route('candidates.index')->with('status', 'Candidate deleted');
	}
}


