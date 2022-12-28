<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(){
        return view('static_pages/faqs', [
            'heading' => 'Frequently Asked Questions',
            'faqs' => Faq::all()
        ]);
    }
}
