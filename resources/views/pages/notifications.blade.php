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

            <p style="padding:10px">{{$notification->data['name']}} {{$notification->data['email']}} {{$notification->data['data']}} {{$notification->created_at}} {{$notification->data['event_title']}}  <a style="color: rgb(7, 0, 105)" href="{{ route('markOne')}}">Mark as read</a></p>
                 
            {{-- if notification is "JoinRequest type" --}}
            @else
            <p style="padding:10px">{{$notification->data['name']}} {{$notification->data['email']}} {{$notification->data['data']}} {{$notification->data['event_title']}} {{$notification->created_at}}  
            <button style="color: rgb(1, 92, 28)" onclick="window.location.href='event/{{$notification->data['event_id']}}/all_participants'">{{$notification->data['action']}}</button> 
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