@section('content')
@include('partials._search_user')
<div style="display: flex;justify-content: center">
<ul>

    @foreach($users as $user)
    <div style="background-color: rgba(0, 0, 0, 0.95); width: 100%; margin-top:30px; border-radius: 1.7em 1.7em 1.7em 1.7em; padding: .1em 3em 1em 3em;" >
      
      
      <a href="{{ route('user', ['id' => $user->id]) }}">
        <h1 class="">{{ $user->name }}
        <h2 class="">{{ $user->firstname }} {{ $user->lastname }}</h2>
        @if ($user->is_admin)
            <h3 class="" style="color: rgb(229, 56, 56)">Admin</h3>
        @endif
        <img src="" alt="">
      </a>
    </div>

    @endforeach

  </ul></div>