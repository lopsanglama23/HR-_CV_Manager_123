<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\InterviewerController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\AssignmentController;
use App\Models\Assessment;
use App\Models\Candidate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Email preview route
Route::get('/email-preview/assessment-notification', function () {
    $candidate = new Candidate(['name' => 'John Doe', 'email' => 'john@example.com']);
    $candidate->id = 1; // Dummy ID for preview
    $assessment = new Assessment([
        'title' => 'Sample Assessment',
        'score' => 85,
        'remarks' => 'Good performance overall.',
        'attachment_path' => 'assessments/sample.pdf'
    ]);
    $assessment->candidate = $candidate;
    return view('emails.assessment_notification', compact('assessment', 'candidate'));
});

Route::get('/dashboard', function () {
    return redirect()->route('candidates.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Candidates & Dashboard
    Route::resource('candidates', CandidateController::class);

    // Nested resources
    Route::post('candidates/{candidate}/assessments', [AssessmentController::class, 'store'])->name('candidates.assessments.store');
    Route::delete('candidates/{candidate}/assessments/{assessment}', [AssessmentController::class, 'destroy'])->name('candidates.assessments.destroy');

    Route::get('candidates/{candidate}/interviews', [InterviewController::class, 'index'])->name('candidates.interviews.index');
    Route::post('candidates/{candidate}/interviews', [InterviewController::class, 'store'])->name('candidates.interviews.store');
    Route::patch('candidates/{candidate}/interviews/{interview}', [InterviewController::class, 'update'])->name('candidates.interviews.update');
    Route::delete('candidates/{candidate}/interviews/{interview}', [InterviewController::class, 'destroy'])->name('candidates.interviews.destroy');

    // Offer letters and templates
    Route::get('offers/templates', [OfferController::class, 'templates'])->name('offers.templates');
    Route::post('offers/templates', [OfferController::class, 'storeTemplate'])->name('offers.templates.store');
    Route::get('candidates/{candidate}/offers/create', [OfferController::class, 'createForCandidate'])->name('offers.create');
    Route::post('candidates/{candidate}/offers/preview', [OfferController::class, 'preview'])->name('offers.preview');
    Route::post('candidates/{candidate}/offers', [OfferController::class, 'storeForCandidate'])->name('offers.store');

    // Interviewers
    Route::get('interviewers', [InterviewerController::class, 'index'])->name('interviewers.index');
    Route::get('interviewers/show', [InterviewerController::class, 'show'])->name('interviewers.show');

    // Assignments
    Route::get('assignments', [AssignmentController::class, 'allAssignments'])->name('assignments.index');
    Route::get('candidates/{candidate}/assignments', [AssignmentController::class, 'index'])->name('assignments.candidate.index');
    Route::get('candidates/{candidate}/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('candidates/{candidate}/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('candidates/{candidate}/assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('candidates/{candidate}/assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::patch('candidates/{candidate}/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::post('candidates/{candidate}/assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit');
});

require __DIR__.'/auth.php';
