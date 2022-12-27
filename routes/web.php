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
use App\Models\Faq;

// Home
Route::get('home', 'HomeController@show');

// Client
Route::get('profile/{id}', 'ClientController@show')->name('user');
Route::get('profile_edit/{id}', [ClientController::class, 'show_edit']);
//Route::post('profile_edit/{id}', 'ClientController@update');
Route::post('profile_edit/{id}', 'ClientController@update')->name('user-update')->middleware('auth');
Route::delete('profile/{id}', 'ClientController@delete')->name('delete_user')->middleware('auth');

// API
Route::patch('api/like/{id}', 'CommentController@like');
Route::get('api/like/{id}', 'CommentController@like');


// Authentication
Route::get('/', 'Auth\LoginController@home')->name('login_home');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/register', 'Auth\RegisterController@index')->name('register')->middleware('guest');
Route::post('/register', 'Auth\RegisterController@register')->name('register_submit')->middleware('guest');

//Event
Route::get('event/{id}', 'EventController@show')->name('event');

Route::get('all_events', 'EventController@list')->name('event_list');
Route::get('event_edit/{id}', [EventController::class, 'show_edit'])->name('event_edit');
Route::post('event_edit/{id}', 'EventController@update')->name('event_update');
Route::delete('event/{id}',[EventController::class, 'delete'])->name('delete_event');
Route::get('event_create', 'EventController@show_create')->name('event_create');
Route::post('event_create', 'EventController@create')->name('create_event');

Route::get('/search', 'EventController@search');

//Comment
Route::post('event/{id}', 'CommentController@create')->name('new_comment');
Route::delete('event/{id}/comment', 'CommentController@delete')->name('delete_comment')->middleware('auth');


Route::get('index', [EventController::class, 'index'])->name('index');

Route::get('about', function(){
    return view('pages/about');
});

Route::get('faqs', function(){
    return view('pages/faqs', [
        'heading' => 'Frequently Asked Questions',
        'faqs' => Faq::all()
    ]);
});