<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('user')->where('status', 'published')->latest()->paginate(6);
        return view('frontend.pages.home.index', compact('blogs'));
    }
}
