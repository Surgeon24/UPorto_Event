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
use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('home' , function(){return view('pages.home');});

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
Route::get('/', 'Auth\LoginController@home')->name('login_home');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/register', 'Auth\RegisterController@index')->name('register')->middleware('guest');
Route::post('/register', 'Auth\RegisterController@register')->name('register_submit')->middleware('guest');

//Event
Route::get('event/{id}', 'EventController@show')->name('event');
Route::get('home', 'EventController@list')->name('event_list');
Route::get('event_edit/{id}', [EventController::class, 'show_edit'])->name('event_edit');
Route::post('event_edit/{id}', 'EventController@update')->name('event_edit');
Route::delete('event/{id}',[EventController::class, 'delete'])->name('delete_event');
//Route::get('event/{id}', 'CommentController@list')->name('comment_list');

//Comment
Route::post('event/{id}', 'CommentController@create')->name('new_comment');
Route::delete('event/{id}/comment', 'CommentController@delete')->name('delete_comment')->middleware('auth');