<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Cancellation Notification</title>
</head>
<body>
<p>Dear {{ $name }},</p>
<p>We regret to inform you that the flight <strong>#{{ $flight->id }}</strong> scheduled from
    <strong>{{ $departure_city_name }}</strong> to
    <strong>{{ $arrival_city_name }}</strong> on
    <strong>{{ $flight->departure_date }}</strong> has been cancelled.</p>
<p>We apologize for the inconvenience caused.</p>
<p>Thank you for your understanding.</p>
</body>
</html>

