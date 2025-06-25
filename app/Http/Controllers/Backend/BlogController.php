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
        $blogs = Blog::with('user')
            ->filter($request->all())
            ->paginate(10);

        return view('backend.pages.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('backend.pages.blog.create');
    }

    public function store(BlogRequest $request)
    {
        $data = $request->only([
            'title', 'slug', 'excerpt', 'content', 'status', 'published_at'
        ]);

        $data['thumbnail'] = $request->file('thumbnail');

        $this->blogService->store($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully.');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('backend.pages.blog.edit', compact('blog'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $data = $request->only(['title', 'slug', 'excerpt', 'content', 'status', 'published_at']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail');
        }

        $this->blogService->update($blog, $data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        $this->blogService->delete($blog);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully!');
    }
}
