<h1>Forget Password Email</h1>

You can reset password from below link:
<a href="{{ route('password.reset', ['email' => encrypt($email), 'token' => $token]) }}">Reset Password</a>