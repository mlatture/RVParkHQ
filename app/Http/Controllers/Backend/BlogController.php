<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Services\BlogService;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['blogs.view']);

        $blogs = Blog::with('user')
            ->filter($request->all())
            ->paginate(10);

        return view('backend.pages.blog.index', compact('blogs'));
    }

    public function create()
    {
        $this->checkAuthorization(auth()->user(), ['blogs.create']);
        return view('backend.pages.blog.create');
    }

    public function store(BlogRequest $request)
    {
        $this->checkAuthorization(auth()->user(), ['blogs.create']);

        $data = $request->only([
            'title', 'slug', 'excerpt', 'content', 'status', 'published_at'
        ]);

        $data['thumbnail'] = $request->file('thumbnail');

        $this->blogService->store($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully.');
    }

    public function edit($id)
    {
        $this->checkAuthorization(auth()->user(), ['blogs.edit']);

        $blog = Blog::findOrFail($id);
        return view('backend.pages.blog.edit', compact('blog'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $this->checkAuthorization(auth()->user(), ['blogs.edit']);

        $data = $request->only(['title', 'slug', 'excerpt', 'content', 'status', 'published_at']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail');
        }

        $this->blogService->update($blog, $data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        $this->checkAuthorization(auth()->user(), ['blogs.delete']);

        $this->blogService->delete($blog);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully!');
    }
}