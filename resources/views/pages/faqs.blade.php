@extends('layouts.layout')

@section('content')

<h1>{{$heading}}</h1>

@unless (count($faqs) == 0)
    

@foreach($faqs as $faq)
<h2>{{$faq['q']}}</h2>
<p>{{$faq['a']}}</p>

@endforeach


@else

<p>No questions found</p>

@endunless

@endsection