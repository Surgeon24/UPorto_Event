<x-layout>

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



<div class="login">
<div class="gray">
  <form method="post" action="{{ route('user-update', ['id' => $user->id]) }}" accept-charset="UTF-8" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div>
      <label for="name">Username</label>
      <input class="bar" type="text" id="name" name="name" value="{{$user['name']}}"></input>
    </div>
    <div>
      <label for="email">Email</label>
      <input class="bar" type="text" id="email" name="email" value="{{$user['email']}}"></input>
      <p></p>
      <label for="exampleFormControlFile1">Profile image</label>
      <input type="file" name="photo_path" class="form-control-file" id="exampleFormControlFile1">
      <button type="submit" name="submit" class="btn btn-danger">submit</button>
    </div>
  </div>

  </form>
</div>
</x-layout>