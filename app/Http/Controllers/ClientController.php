<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class ClientController extends Controller{ 
    public function show($id){
      $user = User::find($id);
      //$this->authorize('show', $user);
      return view('pages.profile', ['user' => $user]);
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

      //$this->authorize('delete', $card);
      $user->delete();

      return redirect('layout/app/')->withSuccess('Your account was successfully deleted!');
    }
}