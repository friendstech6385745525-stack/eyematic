@component('mail::message')
# <img src="{{ url('images/logo.jpg') }}" height="60">

# Reset Your Eyematic Password

Hello **{{ auth()->user()->name ?? 'User' }}**,
Click the button below to reset your password.

@component('mail::button', ['url' => $actionUrl])
Reset Password
@endcomponent

If you didn't request a password reset, ignore this email.

Thanks,<br>
**Eyematic Team** 👓
@endcomponent
