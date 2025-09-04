Interview Scheduled - {{ ucfirst($interview->round) }} Round

Dear {{ $candidate->name }},

Congratulations! We are pleased to inform you that your application has progressed to the interview stage.

Interview Details:
- Round: {{ ucfirst($interview->round) }} Interview
- Date & Time: {{ $interview->scheduled_at->format('F j, Y \a\t g:i A') }}
- Interviewer: {{ $interview->interviewer->name ?? 'TBD' }}
- Location: {{ $interview->location ?? 'To be confirmed' }}
@if($interview->notes)
- Additional Notes: {{ $interview->notes }}
@endif

Please make sure to:
- Arrive 15 minutes early
- Bring a copy of your resume
- Prepare any questions you may have about the role
- Have a stable internet connection if this is a virtual interview

If you need to reschedule or have any questions, please contact us at hr@cellapp.com or call (555) 123-4567.

We look forward to speaking with you!

Best regards,
Cellapp HR Team
Cellapp

---
This is an automated message. Please do not reply to this email.
© {{ date('Y') }} Cellapp. All rights reserved.
