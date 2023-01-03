<x-layout>
  <style>
      .gray{
         position: relative;
         padding: 50px;
         text-align: center;
         background-color: rgba(0, 0, 0, 0.8);
         color: white;       
       }
  
      .bar{
    background-color:#363230;
    color:white;
    border-radius: 15px;
    border: 1px #000 solid;
      }
  
      .login{
          position: absolute;
          top: 50%;
          left: 50%;
          margin: -150px 0 0 -150px;
          width:400px;
          height:300px;
      }
      .error{
          color: red;
          text-emphasis: xs;
          margin-top: 1;
          
          /* text-red-500 text-xs mt-1 */
      }
  </style>
  @php
      $user = App\Models\User::where('id', Auth::id())->first();
      $role = App\Models\User_event::where('user_id', $user->id)->where('event_id', $event->id)->first()->role;
  @endphp
  
  <div class="login"> 
  <div class="gray">
      <h1>Edit Event</h1>
      <form class="mx-auto" method="post" action="{{ route('event_update', ['id' => $event->id]) }}" accept-charset="UTF-8" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" class="form-control" id="title" name="title" value="{{$event['title']}}">
          @error('title')
            <p class="error">{{$message}}</p>
          @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="{{$event['description']}}">
            @error('description')
            <p class="error">{{$message}}</p>
            @enderror
        </div>
        <div class="form-group">
          <label for="location">Location</label>
          <input type="text" class="form-control" id="location" name="location" value="{{$event['location']}}">
          @error('location')
            <p class="error">{{$message}}</p> 
          @enderror
        </div>
        <div class="form-group">
          <label for="start_date">Start Date</label>
          <input type="date" class="form-control" id="start_date" name="start_date" value="{{$event['start_date']}}">

          @error('start_date')
          <p class="error">{{$message}}</p>
          @enderror
        </div>
        <div class="form-group">
          <label for="end_date">End Date</label>
          <input type="date" class="form-control" id="end_date" name="end_date" value="{{$event['end_date']}}">

          @error('end_date')
          <p class="error">{{$message}}</p>
          @enderror
        </div>
        <div>
            <label for="private">
                <input type="checkbox" name="private" {{ !$event->is_public ? 'checked' : '' }}> create private event
            </label>
        </div>
      <div>
        <label for="exampleFormControlFile1">Event image</label>
        <input type="file" name="image_path" class="form-control-file" id="exampleFormControlFile1">
      </div>
      <p></p>
      <button type="submit" name="submit" class="btn btn-primary btn-block btn-large">Submit</button>
    </form>
  </div>
  </div>
        
</x-layout>