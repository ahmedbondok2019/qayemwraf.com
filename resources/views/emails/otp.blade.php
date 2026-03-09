<x-mail::message>
    # Verification Code

    Your verification code is: **{{ $otp }}**

    If you did not request this code, no further action is required.

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>