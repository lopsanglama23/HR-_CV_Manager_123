<!DOCTYPE html>
<html>
<head>
    <title>Interview Reminder</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        p { line-height: 1.6; }
        .button { display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Interview Reminder</h1>

    <p>Hello {{ $interview->interviewer_name }},</p>

    <p>You have an interview scheduled:</p>

    <ul>
        <li><strong>Candidate:</strong> {{ $interview->candidate->name }}</li>
        <li><strong>Round:</strong> {{ ucfirst($interview->round) }}</li>
        <li><strong>Scheduled At:</strong> {{ $interview->scheduled_at->format('d M Y H:i') }}</li>
        <li><strong>Remarks:</strong> {{ $interview->remarks ?: 'None' }}</li>
    </ul>

    <p>Please be prepared for the interview.</p>

    <p>Best regards,<br>
    {{ config('app.name') }} Team</p>
</body>
</html>
