Interview Result - Congratulations!

Dear {{ $interview->candidate->name }},

Congratulations! We are pleased to inform you that you have successfully passed the {{ ucfirst($interview->round) }} round of interviews.

Your performance in the interview was impressive, and we would like to proceed with the next steps in our recruitment process.

Next Steps:
@if($interview->round === 'first')
- You will be scheduled for the Second Round Interview
- Our team will contact you shortly with the interview details
@elseif($interview->round === 'second')
- You will be scheduled for the Third Round Interview
- Our team will contact you shortly with the interview details
@elseif($interview->round === 'third')
- Congratulations! You have successfully completed all interview rounds
- Our HR team will contact you regarding the offer details
@endif

We appreciate your interest in joining Cellapp and look forward to potentially welcoming you to our team.

If you have any questions about the next steps, please feel free to contact us at hr@cellapp.com or call (555) 123-4567.

Best regards,
Cellapp HR Team
Cellapp

---
This is an automated message. Please do not reply to this email.
© {{ date('Y') }} Cellapp. All rights reserved.
