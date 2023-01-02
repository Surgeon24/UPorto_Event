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
        box-sizing: border-box;
        transition: 0.3s;
        border-radius: 5px;
        /* 5px rounded corners */
        border-style: solid;
        border-width: medium;
    }

    /* Add rounded corners to the top left and the top right corner of the image */
    img {
        border-radius: 5px 5px 0 0;
    }

    button.liked {
        color: #0571ed;
    }

    button.liked i {
        animation: anim 0.5s ease-in-out;
        -webkit-animation: anim 0.5s ease-in-out;
    }

    @keyframes anim {
        100% {
            transform: rotate(-15deg) scale(1.3);
            -webkit-transform: rotate(-15deg) scale(1.3);
            -moz-transform: rotate(-15deg) scale(1.3);
            -ms-transform: rotate(-15deg) scale(1.3);
            -o-transform: rotate(-15deg) scale(1.3);
            filter: blur(0.5px);
            -webkit-filter: blur(0.5px);
        }
    }




    .g{
    padding: 50px;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.6);
    color: white;
    height: 300px;
  }

    * {
      box-sizing: border-box;
    }
    
    /* Create two equal columns that floats next to each other */
    .column1 {
      float: left;
      width: 30%;
      padding: 20px;
    }
    .column2 {
      float: left;
      width: 70%;
      padding: 20px;
    }
</style>


{{-- <div class="gray">
    <article class="card">
    <ul>
        <div>
            <p class="nick"><a title="go to profile" href="profile/{{$comment->user_id}}">{{App\Models\User::where('id', $comment->user_id)->first()->name;}}</a></p>
            <p class="avatar"><img src="{{ asset('assets/profileImages/image.png') }}" alt="Profile Picture"></p>
        </div>
        <div>
            <p class="post-time">{{$comment->comment_date}}</p>
            <p class="comment">{{$comment->comment_text}}</p>
            @if(Auth::user()->isStaff() || Auth::user()->id === $comment->user_id)
                <form action="{{ route('delete_comment', ['id' => $comment->event_id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type='hidden' id='id' name='id' value='{{ $comment->id }}'>
                    <button type="submit">
                        Delete
                    </button>
                </form>
            @endif
            <button  class="like" data-id="{{$comment->id}}">
                <i class="fa fa-thumbs-up"></i>
                <span class="icon">Like</span>
            </button>
        </div>
    </ul>
    </article>
</div>    --}}

                
{{--------------------old version -----------------------}}

{{-- <div>
    <div style="display:inline-block;">
        <article class="card">
            <h1 class="">{{ $comment->comment_text }}</h1>
            <p>{{ $comment->comment_date }}</p>
            <div style="display:flex; gap:10px; " class="">
                @if(Auth::user()->isStaff() || Auth::user()->id === $comment->user_id)
                <form action="{{ route('delete_comment', ['id' => $comment->event_id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type='hidden' id='id' name='id' value='{{ $comment->id }}'></input>
                    <button type="submit">
                        Delete
                    </button>
                </form>
                @endif
                <button  class="like"  data-id="{{$comment->id}}">
                    <i class="fa fa-thumbs-up"></i>
                    <span class="icon">Like</span>
                </button>
            </div>
        </article>
    </div>
</div> --}}
















@php
    $user= \App\Models\User::where('id', $comment->user_id)->first();
    $role= \App\Models\User_event::where('event_id', $comment->event_id)->where('user_id', $user->id)->first()->role;
@endphp

<p></p>
<div class="g">
    <div class="column1">
    <td>
        <p class="nick " title="Go to the profile">
            <a href="{{ url('profile?', [$user->id])}}">{{ $user->name }}</a>
        </p>
        <p class="avatar"><img src="{{ url('assets/profileImages?', [$user->photo_path])}}" style="max-height:100px; max-width:100px;" alt="/default-profile-photo.webp"></p>		
        <p></p>
        @if ($user->is_admin == true)
        <p class="admin" style="color:rgb(217, 60, 60);">Admin</p>		
        @elseif ($role != null)
        <p class="admin" style="color:rgb(255, 255, 255);">{{$role}}</p>	
        @endif
    </td>
    </div>
    <div class="column2">
    <td class="column" rowspan="2">
        <div class="post_head">
            <p class="post-time">
                                <span class="hl-scrolled-to-wrap">
                    <div>{{$comment->comment_date}}</div>
                </span>
            </p>
            <div class="clear"></div>
        </div>
        <div class="text">
            {{$comment->comment_text}}
        </div>
        @if(Auth::user()->isStaff() || Auth::user()->id === $comment->user_id)
            <form action="{{ route('delete_comment', ['id' => $comment->event_id]) }}" method="post">
                @csrf
                @method('DELETE')
                <input type='hidden' id='id' name='id' value='{{ $comment->id }}'></input>
                <button type="submit" style="color:rgb(211, 19, 19);">
                    Delete
                </button>
            </form>
            @endif
            <button  class="like" data-id="{{$comment->id}}">
                <i class="fa fa-thumbs-up"></i>
                <span class="icon" style="color:rgb(29, 42, 177);">Like</span>
            </button>
    </td>
    </div>
</div>