@extends('layouts.layout')

@section('content')

<style>
@import url("https://fonts.googleapis.com/css?family=Hind:300,400&display=swap");
* {
  box-sizing: border-box;
}
*::before, *::after {
  box-sizing: border-box;
}

.container {
  margin: 0 auto;
  padding: 4rem;
  width: 48rem;
  background-color: rgba(0, 0, 0, 0.8);
    color: white;
}

.accordion .accordion-item {
  border-bottom: 1px solid #e5e5e5;
}
.accordion .accordion-item button[aria-expanded=true] {
  border-bottom: 1px solid #03b5d2;
}
.accordion button {
  position: relative;
  display: block;
  text-align: left;
  width: 100%;
  padding: 1em 0;
  color: #7288a2;
  font-size: 1.15rem;
  font-weight: 400;
  border: none;
  background: none;
  outline: none;
}
.accordion button:hover, .accordion button:focus {
  cursor: pointer;
  color: #03b5d2;
}
.accordion button:hover::after, .accordion button:focus::after {
  cursor: pointer;
  color: #03b5d2;
  border: 1px solid #03b5d2;
}
.accordion button .accordion-title {
  padding: 1em 1.5em 1em 0;
}
.accordion button .icon {
  display: inline-block;
  position: absolute;
  top: 18px;
  right: 0;
  width: 22px;
  height: 22px;
  border: 1px solid;
  border-radius: 22px;
}
.accordion button .icon::before {
  display: block;
  position: absolute;
  content: "";
  top: 9px;
  left: 5px;
  width: 10px;
  height: 2px;
  background: currentColor;
}
.accordion button .icon::after {
  display: block;
  position: absolute;
  content: "";
  top: 5px;
  left: 9px;
  width: 2px;
  height: 10px;
  background: currentColor;
}
.accordion button[aria-expanded=true] {
  color: #03b5d2;
}
.accordion button[aria-expanded=true] .icon::after {
  width: 0;
}
.accordion button[aria-expanded=true] + .accordion-content {
  opacity: 1;
  max-height: 9em;
  transition: all 200ms linear;
  will-change: opacity, max-height;
}
.accordion .accordion-content {
  opacity: 0;
  max-height: 0;
  overflow: hidden;
  transition: opacity 200ms linear, max-height 200ms linear;
  will-change: opacity, max-height;
}
.accordion .accordion-content p {
  font-size: 1rem;
  font-weight: 300;
  margin: 2em 0;
}
</style>

  <script>
  window.console = window.console || function(t) {};
</script>

  
  
  <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>


</head>

<body translate="no" >
  <div class="container">


  <h2>{{$heading}}</h2>

  
  @unless(count($faqs) == 0)
      
  @foreach($faqs as $faq)
  <div class="accordion">
    <div class="accordion-item">
      <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title">{{$faq['q']}}</span><span class="icon" aria-hidden="true"></span></button>
      <div class="accordion-content">
        <p>{{$faq['a']}}</p>
      </div>
    </div>
    @endforeach

    @else
    <p>No questions found</p>
  @endunless
    
  </div>
</div>


    <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-2c7831bb44f98c1391d6a4ffda0e1fd302503391ca806e7fcc7b9b87197aec26.js"></script>

  <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
      <script id="rendered-js" >
const items = document.querySelectorAll(".accordion button");

function toggleAccordion() {
  const itemToggle = this.getAttribute('aria-expanded');

  for (i = 0; i < items.length; i++) {if (window.CP.shouldStopExecution(0)) break;
    items[i].setAttribute('aria-expanded', 'false');
  }window.CP.exitedLoop(0);

  if (itemToggle == 'false') {
    this.setAttribute('aria-expanded', 'true');
  }
}

items.forEach(item => item.addEventListener('click', toggleAccordion));
//# sourceURL=pen.js
    </script>

  

</body>

</html>
@endsection