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
    </style>
    
    <div class="login"> 
    <div class="gray">
        <h1>Create Event</h1>
        <form method="post" action="{{ route('create_event') }}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title">Title</label>
            <input class="form-control" type="text" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input class="form-control" type="text" id="description" name="description">
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input class="form-control" type="text" id="location" name="location">
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input class="form-control" type="date" id="start_date" name="start_date">
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input class="form-control" type="date" id="end_date" name="end_date">
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-large">Submit</button>
        </form>
    </div>
    </div>
          
</x-layout>