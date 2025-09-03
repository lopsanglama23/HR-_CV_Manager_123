<!DOCTYPE html>
<html>
<head>
    <title>New Assessment Received</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        p { line-height: 1.6; }
        a { color: #007bff; text-decoration: none; }
        .button { display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>New Assessment Received</h1>

    <p>Hello {{ $candidate->name }},</p>

    <p>You have received a new assessment: <strong>{{ $assessment->title }}</strong>.</p>

    @if($assessment->score)
    <p><strong>Score:</strong> {{ $assessment->score }}/100</p>
    @endif

    @if($assessment->remarks)
    <p><strong>Remarks:</strong> {{ $assessment->remarks }}</p>
    @endif

    @if($assessment->attachment_path)
    <p>You can view the attachment <a href="{{ asset('storage/' . $assessment->attachment_path) }}">here</a>.</p>
    @endif

    <p>Best regards,<br>
    {{ config('app.name') }} Team</p>

    <a href="{{ route('candidates.show', $candidate) }}" class="button">View Details</a>
</body>
</html>
