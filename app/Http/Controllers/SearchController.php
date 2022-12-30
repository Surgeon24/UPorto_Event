<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function eventSearch(){
        $search_text = $_GET['search'];
      $event = DB::select("SELECT * FROM event WHERE tsvectors @@ plainto_tsquery('english',:search) 
      ORDER BY ts_rank(tsvectors,plainto_tsquery('english',:search)) 
      DESC;",['search' => $search_text]);
    return view('pages.search',compact('event'));
    }

    public function userSearch(){
        $search_text = $_GET['search'];
      $event = DB::select("SELECT * FROM users WHERE tsvectors @@ plainto_tsquery('english',:search) 
      ORDER BY ts_rank(tsvectors,plainto_tsquery('english',:search)) 
      DESC;",['search' => $search_text]);
    return view('pages.search_user',compact('user'));
    }
}
