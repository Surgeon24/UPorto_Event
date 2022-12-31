<x-layout>

   
<style>
    

    .darker{
        position: relative;
        
        text-align: center;
        background-color: rgb(142, 163, 165);
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
            @if($notification->data['action'] == null)

            <p style="padding:10px">{{$notification->data['name']}} {{$notification->data['email']}} {{$notification->data['data']}} {{$notification->created_at}}  <a style="color: rgb(7, 0, 105)" href="{{ route('markOne')}}">Mark as read</a></p>
                    
            @else
                    {{-- event/{{$notification->data['event_id']}}/all_participants --}}
            <p style="padding:10px">{{$notification->data['name']}} {{$notification->data['email']}} {{$notification->data['data']}} {{$notification->created_at}}  
            <button style="color: rgb(1, 92, 28)" onclick="window.location.href='https://www.google.com/imgres?imgurl=https%3A%2F%2Fimg2.joyreactor.cc%2Fpics%2Fpost%2F%25D0%25BF%25D0%25B5%25D1%2581%25D0%25BE%25D1%2587%25D0%25BD%25D0%25B8%25D1%2586%25D0%25B0-%25D1%2582%25D1%258B-%25D0%25BF%25D0%25B8%25D0%25B4%25D0%25BE%25D1%2580-%25D1%2582%25D1%258B-%25D0%25BF%25D0%25B8%25D0%25B4%25D0%25BE%25D1%2580-5224080.jpeg&imgrefurl=https%3A%2F%2Fjoyreactor.cc%2Fpost%2F3949721&tbnid=CbJhw_DQvEwl7M&vet=12ahUKEwjzn-Tr1aL8AhXIUKQEHSNsApUQMygCegUIARCUAQ..i&docid=T85ZLEpeQyYemM&w=400&h=400&q=%D1%82%D1%8B%20%D0%BF%D0%B8%D0%B4%D0%BE%D1%80&ved=2ahUKEwjzn-Tr1aL8AhXIUKQEHSNsApUQMygCegUIARCUAQ';">{{$notification->data['action']}}</button> 
            <a style="color: rgb(7, 0, 105)" href="{{ route('markOne')}}">Mark as read</a></p>        

            @endif

            </div>
            
            
            @endforeach

            @foreach (auth()->user()->readNotifications as $notification)



            <div>
                <p style="padding:10px" class="lighter">{{$notification->data['name']}} {{$notification->data['email']}} {{$notification->data['data']}} {{$notification->created_at}} (seen)</p>
            </div>
                
            @endforeach

        </div>

</x-layout>