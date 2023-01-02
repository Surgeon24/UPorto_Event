<style>
    .dropbtn {
      background-color: #045aaa;
      color: white;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }
    
    .dropbtn:hover, .dropbtn:focus {
      background-color: #4d669c;
    }
    
    #myInput {
      box-sizing: border-box;
      background-image: url('searchicon.png');
      background-position: 14px 12px;
      background-repeat: no-repeat;
      font-size: 16px;
      padding: 14px 20px 12px 45px;
      border: none;
      border-bottom: 1px solid #ddd;
    }
    
    #myInput:focus {outline: 3px solid #ddd;}
    
    .dropdown {
      color: black;
      position: relative;
      display: inline-block;
      right: 25%;
    }
    
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f6f6f6;
      min-width: 230px;
      overflow: auto;
      border: 1px solid #ddd;
      z-index: 1;
    }
    
    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }
    
    .dropdown a:hover {background-color: #ddd;}
    
    .show {display: block;}
    </style>
{{-- {{route('seach')}} --}}
<form action="{{route('searchByDate')}}" method="POST">
@csrf   
<div class="dropdown">
    <button onclick="myFunction()" class="dropbtn">Advanced Search</button>
    
    <div id="myDropdown" class="dropdown-content">
      <p >start date: <input type="date" class="form-label input-sm" id="from" name="fromDate" value="leave empty" required></p> 
     
      <p>end date: <input type="date" class="form-label input-sm" id="to" name="toDate" required></p> 
      <p>private: <input type="checkbox" name="checkPrivate"></p>
      <input type="submit" value="search"></button>
    </div>

  </div>
</form>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
  const inputs = Array.from(
    document.querySelectorAll('input[name=fromDate], input[name=toDate]')
  );

  const inputListener = e => {
    inputs
      .filter(i => i !== e.target)
      .forEach(i => (i.required = !e.target.value.length));
  };

  inputs.forEach(i => i.addEventListener('input', inputListener));
});
  /* When the user clicks on the button,
  toggle between hiding and showing the dropdown content */
  function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }
  
  </script>