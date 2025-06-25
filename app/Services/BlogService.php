<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogService
{
    public function store(array $data)
    {
        if (isset($data['thumbnail'])) {
            $file = $data['thumbnail'];
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/blog_thumbnails', $filename);
            $data['thumbnail'] = 'blog_thumbnails/' . $filename;
        }

        $data['author_id'] = Auth::id();

        return Blog::create($data);
    }

    public function update(Blog $blog, array $data)
    {
        $data['author_id'] = Auth::id();

        if (isset($data['thumbnail'])) {
            if ($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)) {
                Storage::disk('public')->delete($blog->thumbnail);
            }

            $file = $data['thumbnail'];
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/blog_thumbnails', $filename);
            $data['thumbnail'] = 'blog_thumbnails/' . $filename;
        }

        $blog->update($data);

        return $blog;
    }

    public function delete(Blog $blog)
    {
        if ($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)) {
            Storage::disk('public')->delete($blog->thumbnail);
        }

        return $blog->delete();
    }
}
