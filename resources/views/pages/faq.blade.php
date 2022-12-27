@extends('layouts.layout')

@section('content')


<div class="accordion">
  <div class="accordion-item">
    <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title">{{$faq['q']}}</span><span class="icon" aria-hidden="true"></span></button>
    <div class="accordion-content">
      <p>{{$faq['a']}}</p>
    </div>
  </div>


@endsection