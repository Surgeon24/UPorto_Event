<style>
   

    button.liked {
        color: #2ab638;
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
    text-align: center;
    color: white;
    height: 200px;
    background-color: rgb(97, 106, 134);
  }
    
    .column1 {
      float: left;
      width: 15%;
      padding: 10px;
    }
    .column2 {
      float: left;
      width: 85%;
      padding: 10px;
    }
    .delete{
        float: right;
      width: 20%;
    }
    .like{
        float: right;
      width: 20%;
      padding: 20px;
    }
    .comment_text{
        padding-top: 50px;
    }
</style>
                

@php
    $user= \App\Models\User::where('id', $comment->user_id)->first();
    $role= \App\Models\User_event::where('event_id', $comment->event_id)->where('user_id', $user->id)->first()->role;
    $numberOfVotes = \App\Models\CommentVote::where('comment_id', $comment->id)->get()->count();
@endphp

<p></p>
<div class="g">
    <div class="column1">
    <td>
        <p class="nick " title="Go to the profile">
            <a href="{{ url('profile?', [$user->id])}}" style="color:rgb(30, 19, 188)">{{ $user->name }}</a>
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
                    @if(Auth::user()->is_admin || Auth::user()->id === $comment->user_id)
                        <div class="delete">
                        <form action="{{ route('delete_comment', ['id' => $comment->event_id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type='hidden' id='id' name='id' value='{{ $comment->id }}'></input>
                            <button type="submit" style="color:rgb(211, 19, 19);">
                                Delete
                            </button>
                        </form>
                        </div>
                    @endif
                </span>
            </p>
            <div class="clear"></div>
        </div>
        <div class="comment_text">
            {{$comment->comment_text}}
        </div>
        <div class="like">
        <button  data-id="{{$comment->id}}" style="background-color:rgb(23, 95, 219)">
            <i class="fa fa-thumbs-up"></i>
            <span class="icon" style="color:rgb(248, 248, 248)">Like</span>
        </button>
        </div>
    </td>
    </div>
</div>