<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" >
<head>

  <meta charset="UTF-8">
  
  <link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png" />
  <meta name="apple-mobile-web-app-title" content="CodePen">

  <link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico" />

  <link rel="mask-icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111" />


  <title>UPorto Event</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>
  
  
  <!-- Styles -->
  <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
  
  <script src="//unpkg.com/alpinejs" defer></script>
<style>
  body {
    height: 100%;
    background-image: url("{{ asset('images/night.jpeg') }}");
    background-repeat: no-repeat;
    background-attachment: fixed;  
    background-size: cover;
}
    

  footer {
    position: fixed;
    width: 100%;
    left: 0;
    bottom: 0;
    background-color: rgb(0,0,0,0.4);
    color: white;
    text-align: center;

}
  .flash {
      position: fixed;
      top: 0%;
      text-align:center;
      display: inline;
  }
  .green-flash-message{
    
      background-color: rgba(0, 255, 34, 0.8);
      border-style: solid;
      border-color: rgba(255, 255, 255, 0.753);
      border-width: 1px;
      color: rgb(255, 255, 255);  
  }

  .oneBlock{
    display: inline-block;
  }

</style>

<script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>


</head>

<body translate="no" >

  <x-flash-message/>



  
    <header>
        <h1 id="len7" class="hoverable"  ><a style="color: rgb(201, 205, 248);" href="{{ url('home') }}">UPorto Event</a></h1>
    </header>
    <div id="outer">
      <div>
        <form action="/search">
          <div style="oneBolck">
          <div><button class="search-button" type="submit"><i class="fa fa-search"> </i></button></div>
          <div><input class="round-bar" type="text" placeholder="Search..." name="search"></div>
          </div>
        </form>   
      </div>
    </div>
    <div class="content">



@php
    $user = App\Models\User::where('id', Auth::id())->first();
@endphp  
 <h4>   
<div class="container-fluid">
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <ul class="nav navbar-nav">       
      <li><a id="len1" class="hoverable" href="{{ url('/home') }}" style="color: rgb(164, 224, 243);">Home</a></li>
      <li><a id="len2" class="hoverable" href="{{ url('/about') }}" style="color: rgb(164, 224, 243);">About</a></li>
      <li><a id="len3" class="hoverable" href="{{ url('/all_events') }}" style="color: rgb(164, 224, 243);">Browse events</a></li>
      <li><a id="len3" class="hoverable" href="{{ url('/my_events') }}" style="color: rgb(164, 224, 243);">My events</a></li>
      @if ($user != null and $user->is_admin)
        <li><a id="len3" class="hoverable" href="{{ url('/all_users') }}" style="color: rgb(141, 74, 74);">Search users</a></li>
      @endif
      <li><a id="len4" class="hoverable" href="{{ url('/faqs') }}" style="color: rgb(164, 224, 243);">FAQ</a></li>
    @if (Auth::check())
    <li><a id="len5" class="hoverable" href="{{ url('/logout') }}" style="color: rgb(141, 74, 74);">Logout</a></li>
    <li><a id="len6" class="hoverable" href="{{ url('/profile/'. Auth::user()->id) }}" style="color: rgb(74, 141, 115);">{{ Auth::user()->name }} </a></li>
    
    <li>
    <div class="dropdown">
      <a class="fa fa-bell" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        
        @if(auth()->user()->unreadnotifications->count())
        <span class="badge badge-light">{{auth()->user()->unreadnotifications->count()}}</span>
        @endif
      </a>
    
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">

        <li><a style="color: blue" href="{{ route('markRead')}}">Mark all as Read</a></li>

        @foreach (auth()->user()->unreadNotifications as $notification)

        <li><a href="/notifications">{{$notification->data['name']}} {{$notification->data['data']}}</a></li>
      
        @endforeach

        @foreach (auth()->user()->readNotifications as $notification)

        <li style="background-color: lightgray"><a href="/notifications">{{$notification->data['name']}} {{$notification->data['data']}}</a></li>
            
        @endforeach

      </ul>
    </div>
    </li>

    @elseif (Request::url() != url('/login'))
      <li><a id="len5" class="hoverable" href="{{ url('/login') }}" style="color: rgb(141, 74, 74);">Login</a></li>
    @endif
  </ul>     
      
  </nav>



    <main>
        {{$slot}} 
    </main>


  
    <footer class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-white h-24 mt-24 opacity-90 md:justify-center">
      <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>
    </footer>  
</body>
</html>