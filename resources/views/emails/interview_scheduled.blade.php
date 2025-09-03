<!DOCTYPE html>
<html>
<head>
    <title>Interview Scheduled</title>
</head>
<body>
    <h1>Interview Scheduled</h1>
    <p>Dear {{ $candidate->name }},</p>
    <p>Your {{ ucfirst($interview->round) }} round interview has been scheduled.</p>
    <p><strong>Scheduled At:</strong> {{ $interview->scheduled_at->format('d M Y H:i') }}</p>
    <p><strong>Interviewer:</strong> {{ $interview->interviewer_name }} ({{ $interview->interviewer_email }})</p>
    @if($interview->remarks)
        <p><strong>Remarks:</strong> {{ $interview->remarks }}</p>
    @endif
    <p>Please be prepared for the interview.</p>
    <p>Best regards,<br>HR Team</p>
</body>
</html>
