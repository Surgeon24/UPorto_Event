<x-layout>
  <!-- Styles 
  <link href="{{ asset('css/buttons.css') }}" rel="stylesheet"> -->
<style>
 .gray{
    position: relative;
    padding: 50px;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
  }
</style>

@php
$isAdmin = App\Models\User::where('id', Auth::id())->first()->is_admin;
@endphp

<div class="gray">
  <img class="center" style="max-height:100px; max-width:100px;" src="{{ asset('assets/profileImages/' . $user->photo_path) }}" alt="Profile Picture">
  <div>    
    <h2 class="">{{ $user->name }} </h2>
    <h3 class="">{{ $user->email }} </h3>
  </div>
  @if ($user->id === Auth::id())
    <a href="{{ url('profile_edit/'. $user['id']) }}" class="btn btn-primary">Edit</a>
    <a href="{{ url('event_create/') }}" class="btn btn-primary">Create event</a>
    <a href="{{ url('profile/'. $user['id'].'/change-password') }}" class="btn btn-success">Change password</a>
    <p></p>
  @endif 
  @if ($user->id === Auth::id() or $isAdmin)
    <form action="{{ route('delete_user', ['id' => $user->id]) }}"  method="post">
      @csrf
      @method("DELETE")
      <button type="submit" class="btn btn-danger">
        Delete account
      </button>
    </form>      
  @endif
    @if (!$user->is_admin and $isAdmin and !$user->is_banned)
      <h2><a style="background-color: rgb(255, 0, 0)" href="{{ url('ban_user/'. $user['id']) }}" class="btn btn-primary">Block user</a></h2>
    @endif 
    @if (!$user->is_admin and $isAdmin and $user->is_banned)
      <h2><a style="background-color: rgb(66, 208, 50)" href="{{ url('unban_user/'. $user['id']) }}" class="btn btn-primary">Unblock user</a></h2>
    @endif
</div> 
</x-layout>