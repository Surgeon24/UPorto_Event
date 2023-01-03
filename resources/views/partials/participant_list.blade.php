@section('content')

<style>
  /* Style The Dropdown Button */
  .dropbtn {
    background-color: #303030;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
  }
  
  /* The container <div> - needed to position the dropdown content */
  .dropdown {
    position: relative;
    display: inline-block;
  }
  
  /* Dropdown Content (Hidden by Default) */
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  }
  
  /* Links inside the dropdown */
  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }
  
  /* Change color of dropdown links on hover */
  .dropdown-content a:hover {background-color: #f1f1f1}
  
  /* Show the dropdown menu on hover */
  .dropdown:hover .dropdown-content {
    display: block;
  }
  
  /* Change the background color of the dropdown button when the dropdown content is shown */
  .dropdown:hover .dropbtn {
    background-color: #404040;
  }
  </style>

<div class ="gray">
  <h1> {{$event->title}} </h1>
  <div style=display:inline-block;>
      @foreach($participants as $user)
      @php
          $role = App\Models\User_event::where('user_id', $user->id)
            ->where('event_id', $event->id)->first()->role;
      @endphp
      <article class="card">
        <div class="dropdown"> 
            @if ($user->id != $event->owner_id)
              <h2 class="">{{$user->name}}
                <button class="dropbtn">{{$role}}</button>
                <div class="dropdown-content">
                  <a style="color: rgb(81, 246, 10)" href="{{ route('change_status', ['id'=>$event->id, 'user'=>$user->id, 'role'=>"Moderator"]) }}">Moderator</a>
                  <a href="{{ route('change_status', ['id'=>$event->id, 'user'=>$user->id, 'role'=>"Participant"]) }}">Participant</a>
                  <a style="color: rgb(239, 14, 14)" href="{{ route('change_status', ['id'=>$event->id, 'user'=>$user->id, 'role'=>"Blocked"]) }}">Block user</a>
                </div>
              <h2>
            @else
            <h2>{{$user->name}}  (owner)</h2>
            @endif
        </div> 
      </article>
      @endforeach
    </div>
</div>




