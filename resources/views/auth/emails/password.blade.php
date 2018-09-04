inasinas
Click here to reset your password: <a href="{{ $link = Request()->root().'/password/reset/'. $token.'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
