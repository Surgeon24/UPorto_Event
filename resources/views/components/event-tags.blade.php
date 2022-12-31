@props(['tagsCsv'])

@php
$tags = explode(',', $tagsCsv);
@endphp



<style>
.rcorners {
    border-radius: 25px;
    background: #e7acac;
    margin: 20px;

    width: 100px;
    height: 35px;
}

        </style>



<ul class="">
    @if($tags != [null])
    @foreach($tags as $tag)
  <li class="rcorners">
    <a href="/?tag={{$tag}}">{{$tag}}</a>
  </li>
  @endforeach
  @endif
</ul>

{{-- <h4 class="">{{ $event->tags }} </h4> --}}