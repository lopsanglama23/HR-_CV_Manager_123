<?php

namespace App\Mail;

use App\Models\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InterviewRejection extends Mailable
{
    use Queueable, SerializesModels;

    public Interview $interview;

    /**
     * Create a new message instance.
     */
    public function __construct(Interview $interview)
    {
        $this->interview = $interview;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Interview Rejection - ' . ucfirst($this->interview->round) . ' Round',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.interview_rejection',
            with: [
                'interview' => $this->interview,
                'candidate' => $this->interview->candidate,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
