<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SocialPost;
use Illuminate\Http\Request;

class SocialPostController extends Controller
{
    public function __construct()
    {
        // Adjust permissions as needed
        // $this->middleware('permission:social-post.view')->only(['index']);
        // $this->middleware('permission:social-post.create')->only(['create', 'store']);
        // $this->middleware('permission:social-post.edit')->only(['edit', 'update']);
        // $this->middleware('permission:social-post.delete')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SocialPost::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('tenant_name', 'like', "%{$search}%")
                    ->orWhere('tenant_domain', 'like', "%{$search}%")
                    ->orWhere('article_url', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('backend.pages.social-post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $post = new SocialPost();

        return view('backend.pages.social-post.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        SocialPost::create($data);

        return redirect()
            ->route('admin.social-posts.index')
            ->with('success', __('Social post created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialPost $social_post)
    {
        $post = $social_post;

        return view('backend.pages.social-post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialPost $social_post)
    {
        $data = $this->validateData($request);

        $social_post->update($data);

        return redirect()
            ->route('admin.social-posts.index')
            ->with('success', __('Social post updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialPost $social_post)
    {
        $social_post->delete();

        return redirect()
            ->route('admin.social-posts.index')
            ->with('success', __('Social post deleted successfully.'));
    }

    /**
     * Shared validation rules.
     */
    protected function validateData(Request $request): array
    {
        return $request->validate([
            'tenant_id'     => ['nullable', 'integer'],
            'tenant_name'   => ['nullable', 'string', 'max:255'],
            'tenant_domain' => ['nullable', 'string', 'max:255'],
            'idea_id'       => ['nullable', 'integer'],
            'article_url'   => ['required', 'string', 'max:255'],
            'variants'      => ['required'], // longtext, usually JSON or raw text from AI
            'media'         => ['nullable'], // longtext, optional JSON or text
            'status'        => ['required', 'string', 'max:255'], // e.g., pending|scheduled|published|failed
            'scheduled_for' => ['nullable', 'date'],
        ]);
    }
}
