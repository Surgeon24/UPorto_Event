@section('content')



@include('partials._search')

{{-- @include('partials._filter-search') --}}
<div style="display: flex;justify-content: center">
<ul>

    @foreach($events as $event)
    
    <li style="background-color: rgba(0, 0, 0, 0.95); width: 100%; margin-top:20px;" >
      
      
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
         
      </a>
    </li>

    @endforeach

  </ul></div>