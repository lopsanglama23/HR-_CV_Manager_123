<?php

namespace App\Mail;

use App\Models\Assessment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssessmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Assessment $assessment;

    /**
     * Create a new message instance.
     */
    public function __construct(Assessment $assessment)
    {
        $this->assessment = $assessment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Assessment Received - ' . $this->assessment->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.assessment_notification',
            with: [
                'assessment' => $this->assessment,
                'candidate' => $this->assessment->candidate,
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
