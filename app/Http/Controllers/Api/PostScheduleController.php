<?php

// app/Http/Controllers/Api/PostScheduleController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SocialPost;
use Illuminate\Http\Request;

class PostScheduleController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'tenant_id'     => 'required|integer',
            'tenant_name'   => 'nullable|string',
            'tenant_domain' => 'nullable|string',
            'idea_id'       => 'nullable|integer',
            'article_url'   => 'required|string',
            'variants'      => 'required|array',
            'media'         => 'nullable|array',
        ]);

        $post = SocialPost::create([
            'tenant_id'     => $data['tenant_id'],
            'tenant_name'   => $data['tenant_name'] ?? null,
            'tenant_domain' => $data['tenant_domain'] ?? null,
            'idea_id'       => $data['idea_id'] ?? null,
            'article_url'   => $data['article_url'],
            'variants'      => $data['variants'],
            'media'         => $data['media'] ?? [],
            'status'        => 'pending', // later: 'scheduled' with date/time
        ]);

        return response()->json([
            'message' => 'received',
            'id'      => $post->id,
        ], 201);
    }
}

