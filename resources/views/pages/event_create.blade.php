@extends('layouts.layout')


<style>
    .gray{
       position: relative;
       padding: 50px;
       text-align: center;
       background-color: rgba(0, 0, 0, 0.8);
       color: white;       
     }

    .bar{
  background-color:#363230;
  color:white;
  border-radius: 15px;
  border: 1px #000 solid;
    }

    .login{
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -150px 0 0 -150px;
        width:300px;
        height:300px;
    }
     </style>
@section('content')
     <div class="login"> 
    <div class="gray">
        
        <h1>Create Event</h1>
        <form method="post" action="{{ route('create_event') }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <div>
                <label for="title">Title</label>
                <input class="bar" type="text" id="title" name="title"> </input>
            </div>
            <div>
                <label for="description">Description</label>
                <input class="bar" type="text" id="description" name="description"> </input>
            </div>
            <div>
                <label for="location">Location</label>
                <input class="bar" type="text" id="location" name="location"> </input>
            </div>
            <p></p>
            <button type="submit" class="btn btn-success">submit</button>
        </form>
    </div>
     </div>
@endsection
