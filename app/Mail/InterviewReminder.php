<?php

namespace App\Mail;

use App\Models\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $interview;

    /**
     * Create a new message instance.
     */
    public function __construct(Interview $interview)
    {
        $this->interview = $interview;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Interview Reminder')
                    ->view('emails.interview_reminder');
    }
}
