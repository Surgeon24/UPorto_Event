<link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">

{{-- {{route('seach')}} --}}
<form action="{{route('searchByDate')}}" method="POST">
@csrf   
<div class="dropdownSearch">
    <button onclick="myFunction()" class="dropbtn">Advanced Search</button>
    
    <div id="myDropdown" class="dropdown-content">

      <p >start date: <input type="date" class="form-label input-sm" id="from" name="fromDate" value="leave empty" required style="background: #ebf8fc"></p> 
      <p>end date: <input type="date" class="form-label input-sm" id="to" name="toDate" required style="background: #ebf8fc"></p> 
      <p>private: <input type="checkbox" name="checkPrivate" required style="background: #ebf8fc"></p>
      <p>current events: <input type="checkbox" name="checkRelevance" required style="background: #ebf8fc"></p>
      <input type="submit" value="search" style="background: #b9de81; border-radius: 10px 10px;"></button>

    </div>

  </div>

</form>



  <script>
    // at least one input should be made in the Advanced Search Filter dropdown
    document.addEventListener('DOMContentLoaded', function() {
  const inputs = Array.from(
    document.querySelectorAll('input[name=fromDate], input[name=toDate], input[name=checkPrivate], input[name=checkRelevance]')
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