<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class ClientController extends Controller{ 

  protected $table = 'users';

    public function show($id){
      $user = User::find($id);
      if (Auth::check()) {
        if ($user){
          //$this->authorize('show', $user);
          return view('pages.profile', ['user' => $user]);
        } else {
          abort('404');
        }
      } else {
        return redirect('/login');
      }
    }

    public function show_edit($id){
        $user = User::find($id);
          //$this->authorize('show', $user);
        return view('pages.profile_edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
      $user = User::find($id);
      $user->name = $request->get('name');
      $user->email = $request->get('email');
      $user->save();
      return redirect('profile/' . $id)->withSuccess('Your profile was successfully updated!');
    }

    public function delete(Request $request, $id)
    {
      $user = User::find($id);
      // to be changed 
      $comments = $user->comments();
      $comments->delete();
      // comments shouldnt be deleted
      $user->delete();

      return redirect('home')->withSuccess('Your account was successfully deleted!');
    }
}