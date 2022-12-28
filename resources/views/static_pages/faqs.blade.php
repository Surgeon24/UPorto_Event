<x-layout>


<style>
    .gray{
     position: relative;
     padding: 50px;
     text-align: center;
     background-color: rgba(0, 0, 0, 0.8);
     color: white;       
   }
</style>


<div class="gray">
<h1><b>{{$heading}}</b></h1>

@unless (count($faqs) == 0)
    

@foreach($faqs as $faq)
<div style="padding: 15px">
<h3>Q: {{$faq['q']}}</h3>
<p>A: {{$faq['a']}}</p>
</div>
@endforeach
</div>

@else

<p>No questions found</p>

@endunless

</x-layout>