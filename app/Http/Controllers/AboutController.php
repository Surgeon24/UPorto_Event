<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    // Show all 
    public function index(){
        return view('static_pages/about');
    }
    
}
