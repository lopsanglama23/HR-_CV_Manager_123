<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\OfferLetter;
use App\Models\OfferTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfferController extends Controller
{
	public function templates(): View
	{
		$templates = OfferTemplate::latest()->get();
		return view('offers.templates', compact('templates'));
	}

	public function storeTemplate(Request $request): RedirectResponse
	{
		$data = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'body_markdown' => ['required', 'string'],
		]);
		OfferTemplate::create($data);
		return back()->with('status', 'Template saved');
	}

	public function createForCandidate(Candidate $candidate): View
	{
		$templates = OfferTemplate::all();
		return view('offers.create', compact('candidate', 'templates'));
	}

	public function storeForCandidate(Request $request, Candidate $candidate): RedirectResponse
	{
		$data = $request->validate([
			'position' => ['required', 'string', 'max:255'],
			'start_date' => ['required', 'date'],
			'salary' => ['required', 'string'],
			'reporting_to' => ['required', 'string'],
			'responsibilities' => ['required', 'string'],
			'benefits' => ['required', 'string'],
			'contingencies' => ['required', 'string'],
		]);

		// Generate the markdown content
		$body_markdown = $this->generateOfferLetterMarkdown($data, $candidate);

		OfferLetter::create([
			'title' => $data['position'],
			'body_markdown' => $body_markdown,
			'candidate_id' => $candidate->id,
		]);

		return redirect()->route('candidates.show', $candidate)->with('status', 'Offer created');
	}

	public function preview(Request $request, Candidate $candidate): View
	{
		$data = $request->validate([
			'position' => ['required', 'string', 'max:255'],
			'start_date' => ['required', 'date'],
			'salary' => ['required', 'string'],
			'reporting_to' => ['required', 'string'],
			'responsibilities' => ['required', 'string'],
			'benefits' => ['required', 'string'],
			'contingencies' => ['required', 'string'],
		]);

		// Create a formatted offer letter content
		$body_markdown = $this->generateOfferLetterMarkdown($data, $candidate);

		$offer = new OfferLetter([
			'title' => $data['position'],
			'body_markdown' => $body_markdown,
		]);

		return view('offers.preview', compact('offer', 'candidate', 'data'));
	}

	private function generateOfferLetterMarkdown(array $data, Candidate $candidate): string
	{
		return "# {$data['position']}

Dear {$candidate->name},

We are pleased to offer you the position of {$data['position']} at Cellapp. This letter outlines the terms and conditions of your employment.

## Position Details
- **Position:** {$data['position']}
- **Start Date:** {$data['start_date']}
- **Reporting To:** {$data['reporting_to']}
- **Salary:** {$data['salary']}

## Job Responsibilities
{$data['responsibilities']}

## Benefits
{$data['benefits']}

## Contingencies
{$data['contingencies']}

We look forward to welcoming you to the Cellapp team!

Best regards,  
Cellapp HR Team";
	}
}

