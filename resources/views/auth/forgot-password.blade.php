@extends('layouts.app')

@section('forgot-password')

<form method="POST" action="{{ route('password.email') }}">
{{ csrf_field() }}
    <label for="email">E-mail</label>
    <input name="email" type="text" ></input>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <button type="submit">
        Password-Reset Link
    </button>
</form>

@endsection