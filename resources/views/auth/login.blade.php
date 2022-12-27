@extends('layouts.layout')

@section('content')


<link href="{{ asset('css/login.css') }}" rel="stylesheet">


<div class="login">
	<h1>Login</h1>
    
<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <label for="email">E-mail</label>
    <input name="email" type="text" value="{{ old('email') }}"
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password" >Password</label>
    <input
                    name="password"
                    id="password-input"
                    type="password"
                    class=""
                    required
    >
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label>
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
    </label>

    <button type="submit" class="btn btn-primary btn-block btn-large">
        Login
    </button>
    <a class="button button-outline" href="{{ route('register') }}">Register</a>
</form>
</div>
@endsection
