<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// use Request;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    ///*
    //|--------------------------------------------------------------------------
    //| Login Controller
    //|--------------------------------------------------------------------------
    //|
    //| This controller handles authenticating users for the application and
    //| redirecting them to your home screen. The controller uses a trait
    //| to conveniently provide its functionality to your applications.
    //|
    //*/
    //
    use AuthenticatesUsers;
    //
    ///**
    // * Where to redirect users after login.
    // *
    // * @var string
    // */
    //protected $redirectTo = '/cards';
    //
    ///**
    // * Create a new controller instance.
    // *
    // * @return void
    // */
    //public function __construct()
    //{
    //    $this->middleware('guest')->except('logout');
    //}
    //
    //public function getUser(Request $request){
    //    return $request->user();
    //}
    //
    //public function home() {
    //    return redirect('login');
    //}
    //
    //Tries to login, checks the credentials with both email and username
    /*
}
$isAdmin = Administrator::where('user_id', Auth::user()->id)->exists();

if(!$isAdmin){
    return redirect()->route('home');
    
}
    // if(){
        */
    /*
    protected $redirectTo = '/cards';

    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        if (!(auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]))) {
            return back()->with('status', 'Invalid Login Credentials');

            return redirect()->route('user', ['id' => Auth::user()->id]);
            //return redirect('/profile');
        }
    }
}

 /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getUser(Request $request){
        return $request->user();
    }

    public function home() {
        if (Auth::check()){
            return redirect('home');
        } else
            return redirect('login');
    }

}