<!DOCTYPE html>
<html>
<head>
    <title>Interview Rejection</title>
</head>
<body>
    <h1>Interview Rejection</h1>
    <p>Dear {{ $candidate->name }},</p>
    <p>We regret to inform you that after careful consideration, we have decided not to proceed with your application for the position.</p>
    <p>Your {{ ucfirst($interview->round) }} round interview was completed, but unfortunately, it did not meet our requirements at this time.</p>
    <p>We appreciate the time and effort you invested in the interview process and wish you the best in your future endeavors.</p>
    <p>If you have any questions, please feel free to contact us.</p>
    <p>Best regards,<br>HR Team</p>
</body>
</html>
