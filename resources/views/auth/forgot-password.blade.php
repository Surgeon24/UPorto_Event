<x-layout>

    <form method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}
        <label for="email">E-mail</label>
        <input name="email" type="text" ></input>
        @if ($errors->has('email'))
            <span class="error">
            {{ $errors->first('email') }}
            </span>
        @endif

        <button type="submit" style="color: rgb(5, 5, 89)">
            Password-Reset Link
        </button>
    </form>

</x-layout>