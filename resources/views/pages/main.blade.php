@extends('layouts.app')

@section('content')
<!DOCTYPE html>
                                                    {{-- WELCOME MESSAGE --}}
<html style="font-size: 16px;" lang="ru"><head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Welcome to the UPorto Event">
    <title>Main</title>
    <link rel="stylesheet" href="css/nicepage.css" media="screen">
<link rel="stylesheet" href="css/main.css" media="screen">
    <script class="u-script" type="text/javascript" src="js/nicepage.js" defer=""></script>
    
    
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Main">
    <meta property="og:type" content="website">
  </head>

  <body class="u-body u-xl-mode" data-lang="eng">
    <section class="u-clearfix u-section-1" id="sec-577b">
      <div class="u-clearfix u-sheet u-sheet-1">
        <h2 class="u-text u-text-default u-text-1">Welcome to the UPorto Event</h2>
        {{-- <article class="card">
          <a href="{{ route('event', ['id' => $event->id]) }}">
            <h1 class="">{{ $event->title }}
              <h1>
                <h2 class="">{{ $event->description }} </h2>
                <h3 class="">
                  <label style=display:inline;>Date:</label>
                  {{ $event->start_date }}
    
                </h3>
                <h4 class="">
                  <label style=display:inline;>Location: </label>
                  {{ $event->location }}
                </h4>
          </a>
        </article> --}}

        <h4 class="u-text u-text-default u-text-2"> Slogan, that definitely catch you!</h4>
        @include('partials._search')
      </div>
    </section>
    <section class="u-clearfix u-section-2" id="sec-93d1">
      <div class="u-clearfix u-sheet u-sheet-1">
        <h3 class="u-text u-text-default u-text-1">Latest news</h3>
        <div class="u-clearfix u-expanded-width u-gutter-10 u-layout-wrap u-layout-wrap-1">
          <div class="u-layout">
            <div class="u-layout-row">
              <div class="u-size-30 u-size-60-md">
                <div class="u-layout-col">
                  <div class="u-container-style u-image u-layout-cell u-left-cell u-size-20 u-image-1" src="" data-image-width="150" data-image-height="100">
                    <img alt="" class="u-expanded-width u-image u-image-default u-image-1" data-image-width="20" data-image-height="1333" src="data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJkZWZhdWx0LWltYWdlLXNvbGlkIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNDAwIDI2NSIgc3R5bGU9IndpZHRoOiA0MDBweDsgaGVpZ2h0OiAyNjVweDsiPg0KPHJlY3QgZmlsbD0iI0M2RDhFMSIgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyNjUiLz4NCjxwYXRoIGZpbGw9IiNEOUUzRTgiIGQ9Ik0zOTUuMyw5Ni4yYy01LTAuOC02LjEsMS4xLTguNSwyLjljLTEtMi4zLTIuNi02LjItNy43LTVjMS41LTUuMy0yLjYtOC40LTcuNy04LjRjLTAuNiwwLTEuMiwwLjEtMS44LDAuMg0KCWMtMS44LTQuMS02LTYuOS0xMC43LTYuOWMtNi41LDAtMTEuOCw1LjMtMTEuOCwxMS44YzAsMC40LDAsMC45LDAuMSwxLjNjLTEuMi0wLjgtMi41LTEuMy0zLjktMS4zYy00LjMsMC03LjksNC4yLTcuOSw5LjQNCgljMCwxLjIsMC4yLDIuNCwwLjYsMy41Yy0wLjUtMC4xLTEtMC4xLTEuNi0wLjFjLTYuOSwwLTEyLjUsNS41LTEyLjcsMTIuNGMtMC45LTAuMi0xLjktMC40LTIuOS0wLjRjLTYuNCwwLTExLjcsNS4yLTEyLjUsMTEuOA0KCWMtMS4yLTAuNC0yLjUtMC42LTMuOS0wLjZjLTUuOSwwLTEwLjgsMy44LTEyLjEsOC45Yy0yLjQtMi01LjUtMy4yLTguOS0zLjJjLTYsMC0xMS4xLDMuNy0xMi44LDguOGMtMS41LTEuNC0zLjgtMi4zLTYuMy0yLjMNCgljLTIuMSwwLTQuMSwwLjYtNS41LDEuN2gtMC4xYy0xLjMtNS41LTYuMi05LjUtMTIuMS05LjVjLTIuNCwwLTQuNywwLjctNi42LDEuOWMtMS40LTAuNy0zLTEuMi00LjgtMS4yYy0wLjMsMC0wLjUsMC0wLjgsMA0KCWMtMS41LTQuMS01LjItNy05LjUtN2MtMy4xLDAtNS45LDEuNS03LjgsMy45Yy0yLjItNC44LTYuOC04LjItMTIuMi04LjJjLTUuNiwwLTEwLjUsMy43LTEyLjUsOC44Yy0yLjEtMC45LTQuNC0xLjUtNi45LTEuNQ0KCWMtNi44LDAtMTIuNSwzLjktMTQuNSw5LjNjLTAuMiwwLTAuNSwwLTAuNywwYy01LjIsMC05LjYsMy4yLTExLjQsNy44Yy0yLjctMi44LTctNC41LTExLjgtNC41Yy0zLjMsMC02LjQsMC45LTguOSwyLjMNCgljLTIuMS02LjUtOC0xMi4yLTE4LjEtOS45Yy0yLjctMi4zLTYuMy0zLjctMTAuMS0zLjdjLTIuNSwwLTQuOCwwLjYtNi45LDEuNmMtMi4yLTUuOS03LjktMTAuMS0xNC42LTEwLjFjLTguNiwwLTE1LjYsNy0xNS42LDE1LjYNCgljMCwwLjksMC4xLDEuNywwLjIsMi41Yy0yLjYtNS03LjgtOC40LTEzLjgtOC40Yy04LjMsMC0xNS4xLDYuNS0xNS42LDE0LjZjLTIuOS0zLjItNy01LjMtMTEuNy01LjNjLTcuNCwwLTEzLjUsNS4xLTE1LjIsMTINCgljLTIuOS0zLjUtOS44LTYtMTQuNy02djExOS4yaDQwMFYxMDJDNDAwLDEwMiw0MDAsOTcsMzk1LjMsOTYuMnoiLz4NCjxwYXRoIGZpbGw9IiM4RUE4QkIiIGQ9Ik00MDAsMjA2LjJjMCwwLTI1LjMtMTkuMi0zMy42LTI1LjdjLTEzLjQtMTAuNi0yMy4xLTEyLjktMzEuNy03cy0yMy45LDE5LjctMjMuOSwxOS43cy01OC45LTYzLjktNjEuNS02Ni40DQoJYy0xLjUtMS40LTMuNi0xLjctNS41LTAuOWMtNS4yLDIuNC0xNy42LDkuNy0yNC41LDEyLjdjLTYuOSwyLjktNDEtNTAuNy00OS42LTUzcy04NC4zLDgzLjMtMTAxLjQsNzUuMXMtMjYuOS0yLjMtMzUuNCwzLjUNCgljLTguNiw1LjktMTEsNS45LTE1LjksOC4ycy0xNy4xLTUuOS0xNy4xLTUuOVYyNjVjMCwwLDQwMCwwLjIsNDAwLDB2LTU4LjhINDAweiIvPg0KPHBhdGggZmlsbD0iIzdFOTZBNiIgZD0iTTMzMy40LDE3OWMtMTMuMS05LjMtNDAsNC42LTU1LjEsMTAuN2MtMjMuNiw5LjYtOTQtNTQuNC0xMDcuMi01OS43YzAsMC00LjIsMy43LTkuNiw3LjYNCgljLTMuNS0wLjQtOC40LTUuNy05LjktNC43Yy00LjYsMy4xLTE3LjgsMTUuNC0yOC4zLDI2LjZjLTEwLjUsMTEuMy0xMS43LDAtMTUuOC0wLjZjLTIuNS0wLjQtNTQuMSw0Mi41LTU4LjcsNDMuMQ0KCUMyMi4zLDIwNS4zLDAsMTk3LjUsMCwxOTcuNVYyNjVsNDAwLTAuMXYtNTMuM0M0MDAsMjExLjYsMzQ0LjgsMTg3LjEsMzMzLjQsMTc5eiIvPg0KPHBhdGggZmlsbD0iIzc4OEY5RSIgZD0iTTAsMjY0Ljl2LTU4LjZjMCwwLDguMiwxLjgsMTEuMyw1LjNjMy4xLDMuNiwyNi4xLTQuMiwyNi4xLDQuN3MwLjUsNC4yLDAuNSwxNC44YzAsMTAuNywyMy00LjIsMzguMS0xOC40DQoJczM0LjktNDkuMiwzNi0zNWMxLDE0LjItMTUuMSwzOS4yLTI0LDU2LjRDNzkuMSwyNTEuNCw1MS43LDI2NSw1MS43LDI2NUwwLDI2NC45eiIvPg0KPHBhdGggZmlsbD0iIzc4OEY5RSIgZD0iTTEwMCwyNjVjMCwwLDY2LjctMTI1LjEsNjguMy0xMTYuOHMtNi44LDI5LjcsMi4xLDI2LjFjOC45LTMuNiwxNC42LTE2LDE4LjgtOS41czE2LjIsMzguNiwyMS45LDMzLjgNCgljNS43LTQuNywyMS40LTEzLjEsMjIuNC02LjVjMSw2LjUtMSw1LjMtNS43LDIwLjJDMjIzLjEsMjI3LjEsMjAwLDI2NSwyMDAsMjY1aC0xMGMwLDAsNi0yNC44LDguNi0zNC45YzIuNi0xMC4xLTMuNy0xOS0xMi04LjMNCglzLTIzLDIyLTI0LDE3LjhzLTUuNy0zMC4zLTE4LjgtMTQuMmMtMTMsMTYtMzMuOCwzOS43LTMzLjgsMzkuN2gtMTBWMjY1eiIvPg0KPHBhdGggZmlsbD0iIzc4OEY5RSIgZD0iTTI0NSwyNjVjMCwwLDE5LjgtNTQuNywzMy40LTY0LjJzNTMuNy0yNy45LDQ2LjktMTMuNmMtNi44LDE0LjItMTEsMzQuNC0yMC4zLDQ5LjgNCgljLTkuNCwxNS40LTE4LjgsMjYuMS0xNC4xLDEzLjZjNC43LTEyLjUsNi40LTIzLjMsMy43LTIzLjFDMjcxLjMsMjI5LjEsMjYwLDI2NSwyNjAsMjY1SDI0NXoiLz4NCjwvc3ZnPg0K">
                    <div class="u-container-layout u-valign-middle u-container-layout-1"></div>
                  </div>
                </div>
              </div>
              <div class="u-size-30 u-size-60-md">
                <div class="u-layout-col">
                  <div class="u-size-60">
                    <div class="u-layout-row">
                      <div class="u-align-left u-container-style u-layout-cell u-size-60 u-layout-cell-2">
                        <div class="u-container-layout u-valign-top u-container-layout-2">
                          <h3 class="u-text u-text-2">Changes to the Municipal Touristic tax start on Thursday.</h3>
                        </div>
                      </div>
                      {{-- <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-30 u-layout-cell-3">
                        <div class="u-container-layout u-valign-top u-container-layout-3">
                          <p class="u-text u-text-3">This is a description of the event, that is comming. Some long, long description.</p>
                        </div>
                      </div> --}}
                    </div>
                  </div>
                  <div class="u-size-60">
                    <div class="u-layout-row">
                      <div class="u-align-left u-container-style u-layout-cell u-size-60 u-layout-cell-4">
                        <div class="u-container-layout u-valign-top u-container-layout-4">
                          <p class="u-text u-text-4">This Thursday, November 24, the amendments to the regulation for the Municipal Touristic Tax come into force. In addition to the technical aspects, this second revision incorporates the payment exemption for citizens with disabilities, pilgrims, local accommodation, or refugees.</p>
                        </div>
                      </div>
                      {{-- <div class="u-align-left u-container-style u-grey-10 u-layout-cell u-right-cell u-size-30 u-layout-cell-5">
                        <div class="u-container-layout u-valign-top u-container-layout-5">
                          <p class="u-text u-text-5">This is a text in a box 4. Keep scrolling.</p>
                        </div>
                      </div> --}}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="u-clearfix u-section-3" id="sec-5a77">
      <div class="u-clearfix u-sheet u-sheet-1">
        <h3 class="u-text u-text-default u-text-1">Current events</h3>
        <div class="u-expanded-width u-list u-list-1">
          <div class="u-repeater u-repeater-1">

        
            @php
            $current_events = DB::table('event')->select('id', 'title', 'description', 'start_date')->where('start_date', '>', Carbon\Carbon::now())->get();
            $array = json_decode(json_encode($current_events), true); 
            $n = 0;
            if (count($current_events) >= 3){
              $n = 3;
            } else {
              $n = count($current_events);
            }

            @endphp

            @for ($i =0; $i < $n; $i++)
              <div class="u-container-style u-list-item u-repeater-item">
                <div class="u-container-layout u-similar-container u-container-layout-{{$i+1}}">
                  <img alt="" class="u-expanded-width u-image u-image-default u-image-{{$i+1}}" data-image-width="2000" data-image-height="2000" src="assets/eventImages/party.png">
                  <h3 class="u-text u-text-default u-text-4">{{$array[$i]['title']}}</h3>
                  <p class="u-text u-text-5">{{$array[$i]['description']}}</p>
                  <p class="u-text u-text-5">{{$array[$i]['start_date']}}</p>
                  <a href="/event/{{$array[$i]['id']}}" class="u-active-none u-border-2 u-border-hover-palette-2-base u-border-no-left u-border-no-right u-border-no-top u-border-palette-2-light-1 u-btn u-button-style u-hover-none u-none u-text-body-color u-btn-{{$i+1}}">learn more</a>
                </div>
              </div>
            @endfor

          </div>
        </div>
      </div>
    </section>
    
</body></html>

@endsection
