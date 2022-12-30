<x-layout>

   
<style>
    

    .darker{
        position: relative;
        
        text-align: center;
        background-color: rgb(145, 165, 140);
        color: white; 
    } 

    .lighter{
        position: relative;
        
        text-align: center;
        background-color: rgb(95, 92, 92);
        color: white; 
    }       
    hr{
        width: 70%;
        margin-left: auto;
        margin-right: auto;
        }
</style>

            <div class="gray">
            <a style="color: lightblue" href="{{ route('markRead')}}">Mark all as Read</a><p></p>
            @foreach (auth()->user()->unreadNotifications as $notification)
            
            
            <div class="darker">
                           
            <p style="padding:10px">{{$notification->data['name']}} {{$notification->data['email']}} {{$notification->data['data']}} {{$notification->created_at}} <a style="color: green" href="{{ route('markOne')}}">Mark as read</a></p>
            
            </div>
            
            
            @endforeach

            @foreach (auth()->user()->readNotifications as $notification)



            <div>
                <p style="padding:10px" class="lighter">{{$notification->data['name']}} {{$notification->data['email']}} {{$notification->data['data']}} {{$notification->created_at}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </div>
                
            @endforeach

        </div>

</x-layout>