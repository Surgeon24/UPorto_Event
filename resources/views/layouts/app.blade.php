<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <main>
      <header>
        <h1><a href="{{ url('home') }}">UPorto Event</a></h1>
        @if (Auth::check())
        <a class="button" href="{{ url('/logout') }}"> Logout </a> <!--<span>{{ Auth::user()->name }}</span>-->
        <a class="button" href="{{ url('/profile/'. Auth::user()->id) }}"> {{ Auth::user()->name }} </a>
        @elseif (Request::url() != url('/login'))
          <a class="button" href="{{ url('/login') }}"> Login </a>
        @endif
      </header>
      <section id="content">
        @yield('content')
      </section>
      <section id="profile">
        @yield('profile')
      </section>
      <section id="profile_edit">
        @yield('profile_edit')
      </section>
      <section id="event">
        @yield('event')
      </section>
      <section id="event_edit">
        @yield('event_edit')
      </section>
      <section id="event_create">
        @yield('event_create')
      </section>
    </main>
  </body>
</html>
