@extends('layouts.app')
@section('event')

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
        transition: 0.3s;
        border-radius: 5px;
        /* 5px rounded corners */
    }

    /* Add rounded corners to the top left and the top right corner of the image 
    */
    img {
        border-radius: 5px 5px 0 0;
    }
</style>

<div>
    <div>
        <h1 class="">{{ $event->title }} </h1>
        <h2 class="">{{ $event->description }} </h2>
        <h3 class="">
            <label style=display:inline;>Date:</label>
            {{ $event->start_date }}

        </h3>
        <h4 class="">
            <label style=display:inline;>Location: </label>
            {{ $event->location }}
        </h4>
    </div>
    
    <div>
    
    </div>
</div>

@endsection