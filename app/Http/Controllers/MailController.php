<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReferenceEmail;
use App\Mail\InterviewScheduled;
use App\Mail\InterviewRejection;
use App\Models\Interview;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function sendTestEmail()
    {
        $to = "loplama3621@gmail.com";
        $subject = "Test Email";
        $message = "This is a test email.";
        $headers = "From: cellapp@gmail.com";

        Mail::to($to)->send(new ReferenceEmail($subject, $message, $headers));
    }

    public function sendInterviewScheduledEmail(Interview $interview)
    {
        Mail::to($interview->candidate->email)->send(new InterviewScheduled($interview));
    }

    public function sendInterviewRejectionEmail(Interview $interview)
    {
        Mail::to($interview->candidate->email)->send(new InterviewRejection($interview));
    }
}
