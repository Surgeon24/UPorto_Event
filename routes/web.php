<?php

//use App\
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', 'Auth\LoginController@home')->name('home');
Route::get('home' , function(){return view('pages.home');});
Route::get('main', function(){return view('pages.main');});

// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// Client
Route::get('profile/{id}', 'ClientController@show')->name('user');
Route::get('profile_edit/{id}', [ClientController::class, 'show_edit']);
//Route::post('profile_edit/{id}', 'ClientController@update');
Route::post('profile_edit/{id}', 'ClientController@update')->name('user-update')->middleware('auth');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');


// Authentication
//Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


//Event
Route::get('event/{id}', 'EventController@show')->name('event');
Route::get('home', 'EventController@list')->name('event_list');
//Route::get('event/{id}', 'CommentController@list')->name('comment_list');
