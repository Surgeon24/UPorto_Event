<<<<<<< HEAD
<form action="{{ url('/search')}}">
    <div class="relative border-2 border-gray-100 m-4 rounded-lg">
      <div class="absolute top-4 left-3">
        <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i>
      </div>
      <input type="text" name="search" class="h-14 w-full pl-10 pr-20 rounded-lg z-0 focus:shadow focus:outline-none"
        placeholder="Search for the event..." />
      <div class="absolute top-2 right-2">
        <button type="submit" class="h-10 w-20 text-white rounded-lg bg-red-500 hover:bg-red-600">
          Search
        </button>
      </div>
    </div>
  </form>
=======
<style>

    #searchBarWrap{ 
        display: flex;
        justify-content: center;
    }


    #searchBar{
        border:#1b1a19 solid;
        color:black;
        border-width: .2em;
        border-radius: .7em 0 0 .7em;
        padding: .2em .2em .2em .5em;
        width: 450px;
    }

    #searchBtn{
        border:#ffffff solid;
        border-width: .2em;
        border-radius: 0 .7em .7em 0;
        background-color: #000000;
        color:white;
        font-weight:bold;
        padding-bottom: .2em;
    }

</style>
<div id="searchBarWrap">
    <form action="{{ url('/search')}}">
    <input id="searchBar" type="text" name="search" placeholder="Search..."/>
    <button type="submit" id="searchBtn"><i class="fa fa-search">search</i></button>
    </form>
</div>
>>>>>>> main
