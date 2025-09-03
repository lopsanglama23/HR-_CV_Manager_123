<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InterviewerController extends Controller
{
    public function index(): View
    {
        $interviewers = config('interviewers');
        return view('interviewers.index', compact('interviewers'));
    }

    public function show(Request $request): View
    {
        $email = $request->query('email');
        $interviewer = collect(config('interviewers'))->firstWhere('email', $email);

        if (!$interviewer) {
            abort(404, 'Interviewer not found');
        }

        $interviews = Interview::where('interviewer_email', $email)
            ->with('candidate')
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('interviewers.show', compact('interviewer', 'interviews'));
    }
}
