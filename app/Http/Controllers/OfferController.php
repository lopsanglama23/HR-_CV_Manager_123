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
			'title' => ['required', 'string', 'max:255'],
			'body_markdown' => ['required', 'string'],
		]);
		$data['candidate_id'] = $candidate->id;
		OfferLetter::create($data);
		return redirect()->route('candidates.show', $candidate)->with('status', 'Offer created');
	}
}


