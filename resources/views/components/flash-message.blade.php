@if(session()->has('message'))
  
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="flash" >
    <p class="red">{{session('message')}}</p>
    </div>
@endif