<!DOCTYPE html>
<html>

<head>
    <title>Salary Details</title>
</head>

<body>
    <h2>Hello {{ $user->name }},</h2>
    <p>Your salary for the month <strong>{{ $month }}</strong> has been processed.</p>

    <p>Thank you for your hard work!</p>

    <br>
    <p><a href="{{ route('user.sallery') }}">Download Sallery Slip Link </a></p>
</body>

</html>
