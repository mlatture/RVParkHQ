<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();

        if ($request->blog)
        {
            $query->where('slug', $request->blog);
        }

        $blogs = $query->orderBy('id', "DESC")->paginate(10);

        $blogs_search = Blog::orderBy('id', "DESC")->select('slug', 'title')->get();
        return view('frontend.pages.blog.index', compact('blogs', 'blogs_search'));
    }

    public function show($slug)
    {
        $blog = Blog::with('user')->where('slug', $slug)->firstOrFail();
        return view('frontend.pages.blog.show', compact('blog'));
    }
}
