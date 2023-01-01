@props(['tagsCsv'])

@php
$tags = explode(',', $tagsCsv);
@endphp



<style>
.round {
    border-radius: 40%;
    background: #000000;
    margin: 20px;
    width: 100px;
    height: 35px;
}
</style>



<ul class="">
    @if($tags != [null])
    @foreach($tags as $tag)
  <button class="round">
    <a style="color: aliceblue" href="/search?search={{$tag}}">{{$tag}}</a>
  </button>
  @endforeach
  @endif
</ul>