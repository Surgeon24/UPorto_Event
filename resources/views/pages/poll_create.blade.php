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
        <h1>Create new poll</h1>
        <form method="post" action="{{ route('create_poll', $event->id) }}" accept-charset="UTF-8" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="question">Question</label>
            <input class="form-control" type="text" id="question" name="question" placeholder="Put the question of the poll">

            @error('question')
            <p class="error">{{$message}}</p>
            @enderror

        </div>
        <div class="form-group">
            <label for="option_1">First option</label>
            <input class="form-control" type="text" id="option_1" name="option_1" placeholder="...">

            @error('option_1')
            <p class="error">{{$message}}</p>
            @enderror

        </div>
        <div class="form-group">
            <label for="option_2">First option</label>
            <input class="form-control" type="text" id="option_2" name="option_2" placeholder="...">

            @error('option_2')
            <p class="error">{{$message}}</p>
            @enderror

        </div>
        <button type="submit" class="btn btn-primary btn-block btn-large">Submit</button>
        </form>
    </div>
    </div>
          
</x-layout>