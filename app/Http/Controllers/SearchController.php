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


    public function searchByDate(Request $request){
      $fromDate = $request->input('fromDate');
      $toDate   = $request->input('toDate');
      $checkPrivate = $request->input('checkPrivate');
      
      if($checkPrivate == null){
        if($toDate == null){
          $event = DB::table('event')->select()
          ->where('start_date', '>=', $fromDate)
          ->where('is_public', '=', true) 
          ->get();
        }
        elseif($fromDate == null){
          $event = DB::table('event')->select()
          ->where('end_date', '<=', $toDate)
          ->where('is_public', '=', true) 
          ->get();
        }
        else{
          $event = DB::table('event')->select()
          ->where('start_date', '>=', $fromDate)
          ->where('end_date', '<=', $toDate)
          ->where('is_public', '=', true) 
          ->get();
        }
      }
      else{
        if($toDate == null){
          $event = DB::table('event')->select()
          ->where('start_date', '>=', $fromDate)
          ->where('is_public', '=', false) 
          ->get();
        }
        elseif($fromDate == null){
          $event = DB::table('event')->select()
          ->where('end_date', '<=', $toDate)
          ->where('is_public', '=', false) 
          ->get();
        }
        else{
          $event = DB::table('event')->select()
          ->where('start_date', '>=', $fromDate)
          ->where('end_date', '<=', $toDate)
          ->where('is_public', '=', false) 
          ->get();
        }
      }

      dd($event);
      return view('pages.search',compact('event'));
    } 


}
