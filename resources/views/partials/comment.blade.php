<style>
  .card {
    /* Add shadows to create the "card" effect */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    transition: 0.3s;
  }

  /* On mouse-over, add a deeper shadow */
  .card:hover {
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
  }

  /* Add some padding inside the card container */
  .container {
    padding: 2px 16px;
  }

  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    transition: 0.3s;
    border-radius: 5px;
    /* 5px rounded corners */
    border-style: solid;
    border-width: medium;
  }

  /* Add rounded corners to the top left and the top right corner of the image */
  img {
    border-radius: 5px 5px 0 0;
  }
</style>


<div>
  <div style=display:inline-block;>
    <article class="card">
      <h1 class="">{{ $comment->comment_text }}
        <h1>
          <h2 class="">{{ $comment->comment_date }} </h2>
          <form action="{{ route('delete_comment', ['id' => $comment->event_id]) }}"  method="post">
            @csrf
            @method("DELETE")
            <input type='hidden' id='id' name='id' value='{{ $comment->id }}'></input> 
            <button type="submit">
              Delete
            </button>
          </form>
    </article>
  </div>
</div>