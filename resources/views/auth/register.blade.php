<x-layout>

<link href="{{ asset('css/login.css') }}" rel="stylesheet">
<div class="login">
	<h1>Register</h1>
<form method="POST" action="{{ route('register_submit') }}">
    {{ csrf_field() }}

    <label for="name">Name</label>
    <input id="name" type="text" name="name" required autofocus>
    @if ($errors->has('username'))
      <span class="error">
          {{ $errors->first('username') }}
      </span>
    @endif

    <label for="email">E-Mail Address</label>
    <input id="email" type="text" name="email" required>
    @if ($errors->has('email'))
      <span class="error">
          <p>{{ $errors->first('email') }}</p>
      </span>
    @endif

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif
      <p></p>
    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>
    <button type="submit"  class="btn btn-primary btn-block btn-large" >
      Register
    </button>
    <a class="button button-outline" href="{{ route('login') }}">Login</a>
</form>
</div>
</x-layout>