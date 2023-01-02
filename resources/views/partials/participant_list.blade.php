@section('content')


<div class ="gray">
  <h1> {{$event->title}} </h1>
  <div style=display:inline-block;>
      @foreach($participants as $user)
      @php
          $role = App\Models\User_event::where('user_id', $user->id)
            ->where('event_id', $event->id)->first()->role;
      @endphp
      <article class="card">
      <h2 class="">{{$user->name}}  :  {{$role}}
        @if($role === 'Unconfirmed')  
            <a class="button" href="{{ route('add_participant', ['id'=>$event->id, 'user'=>$user->id]) }}"> Accept </a>
            
        @endif
      <h2>
      </article>
      @endforeach
    </div>
</div>