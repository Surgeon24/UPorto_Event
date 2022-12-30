@extends('layouts.app')

@section('forgot-password')

<form method="POST" action="{{ route('password.update') }}">
{{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $request->token }}"></input>

    <input id="email" name="email" type="email" value="{{old('email', $request->email)}}"></input>

    <label for="password">New Password</label>
    <input name="password" type="password" ></input>

    <label for="password_confirmation">Confirm Password</label>
    <input name="password_confirmation" type="password" ></input>

    <button type="submit">
        Change Password
    </button>
</form>

@endsection