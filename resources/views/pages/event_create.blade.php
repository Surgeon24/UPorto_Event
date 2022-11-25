@extends('layouts.app')

@section('event_create')
    <div >
        <form method="post" action="{{ route('create_event') }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <div>
                <label for="title">Title</label>
                <input type="text" id="title" name="title"> </input>
            </div>
            <div>
                <label for="description">Description</label>
                <input type="text" id="description" name="description"> </input>
            </div>
            <div>
                <label for="location">Location</label>
                <input type="text" id="location" name="location"> </input>
            </div>
            <button type="submit">submit</button>
        </form>
    </div>
@endsection
