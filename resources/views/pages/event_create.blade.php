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
    
    <div class="login"> 
    <div class="gray">
        <h1>Create Event</h1>
        <form method="post" action="{{ route('create_event') }}" accept-charset="UTF-8" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title">Title</label>
            <input class="form-control" type="text" id="title" name="title" placeholder="New Year's Eve">

            @error('title')
            <p class="error">{{$message}}</p>
            @enderror

        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input class="form-control" type="text" id="description" name="description" placeholder="Farewell to 2022">

            @error('description')
            <p class="error">{{$message}}</p>
            @enderror


        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input class="form-control" type="text" id="location" name="location" placeholder="Porto, Portugal">

            @error('location')
            <p class="error">{{$message}}</p> 
            @enderror


        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input class="form-control" type="date" id="start_date" name="start_date">

            @error('start_date')
            <p class="error">{{$message}}</p>
            @enderror


        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input class="form-control" type="date" id="end_date" name="end_date">

            @error('end_date')
            <p class="error">{{$message}}</p>
            @enderror


        </div>
        <div>
            <label for="exampleFormControlFile1">Event image</label>
            <input type="file" name="image_path" class="form-control-file" id="exampleFormControlFile1">
        </div>
        <div>
            <label for="private">
            <input type="checkbox" name="private" {{ old('private') ? 'checked' : '' }}> create private event
            </label>
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-large">Submit</button>
        </form>
    </div>
    </div>
          
</x-layout>