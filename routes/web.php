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

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Models\Faq;
use Illuminate\Notifications\Notification;

// Static Pages
Route::get('home', 'HomeController@show');
Route::get('about', [AboutController::class, 'index']);
Route::get('faqs', [FaqController::class, 'index']);

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
Route::get('/forgot-password', 'Auth\RecoverPasswordController@show')->middleware('guest')->name('password.request');
Route::post('/forgot-password', 'Auth\RecoverPasswordController@sendEmail')->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', 'Auth\RecoverPasswordController@showResetPassword')->middleware('guest')->name('password.reset');
Route::post('/reset-password', 'Auth\RecoverPasswordController@resetPassword')->middleware('guest')->name('password.update');

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
Route::get('my_events', 'EventController@list_participations')->name('my_events');
Route::get('event/{id}/join', 'EventController@join')->name('join_event');
Route::get('event/{id}/quit', 'EventController@quit')->name('join_event');
Route::get('event/{id}/all_participants', 'EventController@show_participants')->name('all_participants');


//Search
Route::get('search', 'SearchController@eventSearch');
Route::get('search_user', 'SearchController@userSearch');

//Comment
Route::post('event/{id}', 'CommentController@create')->name('new_comment');
Route::delete('event/{id}/comment', 'CommentController@delete')->name('delete_comment')->middleware('auth');


Route::get('index', [EventController::class, 'index'])->name('index');


Route::get('markAsRead', function(){
    auth()->user()->unreadNotifications->markAsRead();

    return redirect()->back();
})->name('markRead');


Route::get('markOne', function(){
    $id = auth()->user()->unreadNotifications[0]->id;

    auth()->user()->unreadNotifications->where('id', $id)->markAsRead();

    return redirect()->back();
})->name('markOne');

Route::get('notifications', function(){
    return view('pages.notifications');
});




