<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
      $user = DB::select("SELECT * FROM users WHERE tsvectors @@ plainto_tsquery('english',:search) 
      ORDER BY ts_rank(tsvectors,plainto_tsquery('english',:search)) 
      DESC;",['search' => $search_text]);
      return view('pages.search_user',compact('user'));
    }


    public function searchByDate(Request $request){
      $fromDate = $request->input('fromDate');
      $toDate   = $request->input('toDate');
      $checkPrivate = $request->input('checkPrivate');
      $checkRelevance = $request->input('checkRelevance');

      if($toDate == null && $fromDate != null){
        $event = DB::table('event')->select()
        ->where('start_date', '>=', $fromDate)
        ->get();
      }
      elseif($fromDate == null && $toDate != null){
        $event = DB::table('event')->select()
        ->where('end_date', '<=', $toDate) 
        ->get();
      }
      elseif($fromDate == null && $toDate == null){
        $event = DB::table('event')->select()->get();
      }
      else{
        $event = DB::table('event')->select()
        ->where('start_date', '>=', $fromDate)
        ->where('end_date', '<=', $toDate)
        ->get();
      }

      if($checkPrivate == true){
        $event = $event->where('is_public', false);
      }
      
      if($checkRelevance == true){
        $event = $event->where('end_date','>', Carbon::now());
      }

      return view('pages.search',compact('event'));
    } 


}
