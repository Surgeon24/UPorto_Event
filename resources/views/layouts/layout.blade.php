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
  
  <link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
  <!-- Styles -->
  <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
  
  <style>
    body {
      height: 100%;
  background-image: url("{{ asset('images/night.jpeg') }}");
  background-repeat: no-repeat;
  background-attachment: fixed;  
  background-size: cover;
}
    </style>
  
  <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>


</head>

<body translate="no" >
    <header>
        <h1 id="len7" class="hoverable"  ><a style="color: rgb(201, 205, 248);" href="{{ url('home') }}">UPorto Event</a></h1>
    </header>
    <div class="content">
      @if (Request::url() != url('/login') && Request::url() != url('/register'))    
      <div class="search-parent">
        <div class="search-right">
            <form action="/search">
              <input class="round-bar" type="text" placeholder="Search.." name="search">
              <button class="search-button" type="submit">Search</button>
            </form>        
        </div>
      </div>
    @endif



    
<div class="container-fluid">
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">       
        <li><a id="len1" class="hoverable" href="{{ url('/home') }}" style="color: rgb(164, 224, 243);">Home</a></li>
        <li><a id="len2" class="hoverable" href="{{ url('/about') }}" style="color: rgb(164, 224, 243);">About</a></li>
        <li><a id="len3" class="hoverable" href="{{ url('/all_events') }}" style="color: rgb(164, 224, 243);">Browse events</a></li>
        <li><a id="len4" class="hoverable" href="{{ url('/faq') }}" style="color: rgb(164, 224, 243);">FAQ</a></li>

        @if (Auth::check())
        <li><a id="len5" class="hoverable" href="{{ url('/logout') }}" style="color: rgb(141, 74, 74);">Logout</a></li>
        <li><a id="len6" class="hoverable" href="{{ url('/profile/'. Auth::user()->id) }}" style="color: rgb(74, 141, 115);">{{ Auth::user()->name }} </a></li>
        @elseif (Request::url() != url('/login'))
          <li><a id="len5" class="hoverable" href="{{ url('/login') }}" style="color: rgb(141, 74, 74);">Login</a></li>
        @endif
      </ul>
    </div>
  </nav>

  <main>
    @yield('content')
    
</main>

  <footer
  class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-white h-24 mt-24 opacity-90 md:justify-center">
  <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>
  </footer>

</body>

</html>