@section('content')

<style>
  .card {
    /* Add shadows to create the "card" effect */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    transition: 0.3s;
  }

  /* On mouse-over, add a deeper shadow */
  .card:hover {
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
  }

  /* Add some padding inside the card container */
  .container {
    padding: 2px 16px;
  }

  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    transition: 0.3s;
    border-radius: 5px;
    /* 5px rounded corners */
    border-style: solid;
    border-width: medium;
  }

  /* Add rounded corners to the top left and the top right corner of the image */
  img {
    border-radius: 5px 5px 0 0;
  }
</style>


<div>
  <div style="display:flex; gap:10px;">
    @foreach($events as $event)
    <article class="card">
      <a href="{{ route('event', ['id' => $event->id]) }}">
        <h1 class="">{{ $event->title }}
          <h1>
            <h2 class="">{{ $event->description }} </h2>
            <h3 class="">
              <label style=display:inline;>Date:</label>
              {{ $event->start_date }}

            </h3>
            <h4 class="">
              <label style=display:inline;>Location: </label>
              {{ $event->location }}
            </h4>
      </a>
    </article>
    @endforeach
  </div>
</div>
