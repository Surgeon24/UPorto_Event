<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\IsValidPassword;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller{ 

  protected $table = 'users';

    public function show($id){
      $user = User::find($id);
      $isAdmin = User::where('id', Auth::id())->first()->is_admin;
      if (Auth::check() and (Auth::id() == $id or $isAdmin)) {
        if ($user){
          //$this->authorize('show', $user);
          return view('pages.profile', ['user' => $user]);
        } else {
          return redirect('/login');
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
      $request->validate([
          'name' => 'required|min:3',
          'email' => 'required|email'
      ]);
      $input = $request->all();
      if($request->file('photo_path') != null){
        // $request->validate([
        //   'image_path' => 'max:2047',
        // ]);
        $image = $request->file('photo_path');
        $image_name = $image->getClientOriginalName();
        $image->move('assets/profileImages/', $id.".{$image->getClientOriginalExtension()}");
        $path = $id.".{$image->getClientOriginalExtension()}";

        $user = User::find($id);
        $user->photo_path = $path;
        $user->save();
      }
        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->save();

      return redirect('profile/' . $id)->withSuccess('Your profile was successfully updated!');
    }

    public function getPassword($id){
      $user = User::find($id);
      return view('auth.change-password', ['user'=> $user]);
    }

    public function changePassword(Request $request){
      #Validation
      $request->validate([
        'currentPassword' => 'required',
        'password' => ['required','confirmed', new IsValidPassword()],
      ]);

      #Match the old password
      if(!Hash::check($request->currentPassword, auth()->user()->password)){
          return back()->with("error", "Old password doesn't match!");
      }

      #Update the new password
      User::whereId(auth()->user()->id)->update([
          'password' => Hash::make($request->password)
      ]);
      return back()->with('message', 'Password changed successfully!');
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


    public function list()
    {
      $user = User::find(Auth::id());
      if($user->is_admin){
        $all_users = User::orderBy('id')->get();
        return view('pages.all_users', ['user' => $all_users]);
      }
      return redirect('home');
    }

    public function ban_user($id)
    {
      $user = User::where('id', $id)->first();
      $isAdmin = User::find(Auth::id())->is_admin;
      if($isAdmin){
        $user->is_banned = true;
        $user->save();
        return redirect('profile/'.$id)->withSuccess('You blocked the user');
      }
      return redirect('home');
    }

    public function unban_user($id)
    {
      $user = User::where('id', $id)->first();
      $isAdmin = User::find(Auth::id())->is_admin;
      if($isAdmin){
        $user->is_banned = false;
        $user->save();
        return redirect('profile/'.$id)->withSuccess('You unblocked the user');
      }
      return redirect('home');
    }
}