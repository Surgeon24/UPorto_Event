@props(['tagsCsv'])

@php
$tags = explode(',', $tagsCsv);
@endphp


<style>
.round {
    border-radius: 30%;
    margin: 40px;
    min-width: 100px;
    height: 35px;
    background: rgba(68, 68, 68, 0.589)
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