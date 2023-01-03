<x-layout>

<link href="{{ asset('css/about.css') }}" rel="stylesheet">

<div class="about-section">
    <h1>About Us Page</h1>

    <p>Some text about who we are and what we do.</p>
    <p>Resize the browser window to see that this page is responsive by the way.</p>
  </div>
  
  <h2 style="text-align:center">Our Team</h2>
  <div class="row">
    <div class="column">
      <div class="card">
        
        {{-- 350x450 --}}
        <img src="{{asset('images/david.jpg')}}" alt="David" style="width:100%">     
          <div class="gray">
          <h2>David Burchakov</h2>
          <p class="title">FEUP</p>
          <p>Erasmus student</p>
          <p>up202203777@fe.up.pt</p>
          <p><button class="button" onclick="window.location.href='https://www.facebook.com/spleentery/';" >Contact</button></p>
          </div>
      </div>
    </div>
  
    <div class="column">
      <div class="card">
        <img src="{{asset('images/mike.jpg')}}" alt="Mike" style="width:100%">

        <div class="gray">
          <h2>Mikhail Ermolaev</h2>
          <p class="title">FEUP</p>
          <p>Erasmus student</p>
          <p>up202203498@fe.up.pt</p>
          <p><button class="button" onclick="window.location.href='https://www.facebook.com/profile.php?id=100009885852706';">Contact</button></p>
        </div>
      </div>
    </div>
    
    <div class="column">
        <div class="card">
          <img src="{{asset('images/valter.jpeg')}}" alt="Valter" style="width:100%">
          <div class="gray">
            <h2>Valter Castro</h2>
            <p class="title">FEUP</p>
            <p>student</p>
            <p>up201706546@edu.fe.up.pt</p>
            <p><button class="button" onclick="window.location.href='https://www.facebook.com/search/top?q=valter%20castro';" >Contact</button></p>
          </div>
        </div>
      </div>

      <div class="column">
        <div class="card">
          <img src="{{asset('images/jao.jpg')}}" alt="Jao" style="width:100%">
          <div class="gray">
            <h2>Joao de Sousa</h2>
            <p class="title">FEUP</p>
            <p>student</p>
            <p>up201904739@edu.fc.up.pt</p>
            <p><button class="button" onclick="window.location.href='https://www.facebook.com/search/top?q=joao%20bernardo%20pereira%20de%20sousa';">Contact</button></p>
          </div>
        </div>
      </div>

  </div>



</x-layout>