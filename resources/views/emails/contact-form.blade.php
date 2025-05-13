<!DOCTYPE html>
<html>
<head>
    <title>Nouveau message du formulaire de contact</title>
</head>
<body>
    <h2>Nouveau message de {{ $details['name'] }}</h2>
    <p><strong>De:</strong> {{ $details['name'] }} ({{ $details['email'] }})</p>
    <p><strong>Message:</strong></p>
    <p>{{ $details['message'] }}</p>
</body>
</html>