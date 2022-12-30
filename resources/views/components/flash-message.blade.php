@if(session()->has('message'))
  
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 7000)" x-show="show" class="flash" >
    <p class="green-flash-message">{{session('message')}}</p>
    </div>

@endif