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

.srch
{
    display: inline-block;
    max-width: 100 px;
}

</style>
<div id="searchBarWrap">
    <form action="{{ url('/search')}}">
            {{-- <div class="srch">@include('partials._filter-search')</div> --}}
            <div class="srch"><input id="searchBar" type="text" name="search" placeholder="Search..."/>
            <button type="submit" id="searchBtn"><i class="fa fa-search">search</i></button></div>
    </form>
</div>