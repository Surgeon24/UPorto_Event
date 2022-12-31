@section('content')



@include('partials._search')
<p><a href="">qlwken</a></p>
    @foreach($events as $event)
    
      
      <div class="gray">
      <a href="{{ route('event', ['id' => $event->id]) }}">
        <h1 class="">{{ $event->title }}
          <h1>
            <h2 class="">{{ $event->description }} </h2>
            <h3 class="">
              <label style=display:inline;>Date:</label>
              {{ $event->start_date }}

              <x-event-tags :tagsCsv="$event->tags" />
            </h3>
            <h4 class="">
              <label style=display:inline;>Location: </label>
              {{ $event->location }}
            </h4>
            <img src="" alt="">
            </div>
      </a>
    @endforeach

