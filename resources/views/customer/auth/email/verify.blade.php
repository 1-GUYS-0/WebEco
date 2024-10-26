<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email Address</title>
</head>
<body>
    <h1>Verify Your Email Address</h1>
    <p>Hi {{ $customer->name }},</p>
    <p>Thank you for registering. Please click the link below to verify your email address:</p>
    <p><a href="{{ $verificationUrl }}">Verify Email</a></p>
    <p>If you did not create an account, no further action is required.</p>
</body>
</html>