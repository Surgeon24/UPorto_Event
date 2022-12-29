<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\TaskCompleted;

class HomeController extends Controller
{
    public function show(){

        User::find(1)->notify(new TaskCompleted);
        return view('static_pages.home');
    }
}
