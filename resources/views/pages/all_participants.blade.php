<div >
    <div style=display:inline-block;>
        @foreach($participants as $user)
        <article class="card">
        <h1 class="">{{ $user->name }} <h1>
        </article>
        @endforeach
      </div>
</div>