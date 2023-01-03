

@section('content')



@include('partials._search')

@include('partials._filter-search')
<div style="display: flex;justify-content: center">
<ul>

    @foreach($events as $event)
    
    @php
      $photo = App\Models\Photo::where('event_id', $event->id)->first();
      if($photo != null){
          $image_path = App\Models\Photo::where('event_id', $event->id)->first()->image_path;
      } else {
          $image_path = "party.png";
      }
    @endphp

    <div style="background-color: rgba(0, 0, 0, 0.95); width: 100%; margin-top:30px; border-radius: 1.7em 1.7em 1.7em 1.7em; padding: .1em 3em 1em 3em;" >
      
      
      <a href="{{ route('event', ['id' => $event->id]) }}">
        <h1 class="">{{ $event->title }}
          <div class="e_photo">
            <img src="{{ asset('assets/eventImages/' .$image_path) }}" style="max-height:100px; max-width:100px;" alt="Event Picture">
          </div>
          <div class="e_content">
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
          </div>
      </a>
    </div>
    @endforeach

  </ul></div>