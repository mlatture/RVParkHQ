<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParkController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'website_url' => 'nullable|url|max:255',
            'main_image_url' => 'nullable|url|max:255',
            'status' => 'nullable|in:active,inactive',
            'is_featured' => 'nullable|boolean',
            'amenity_ids' => 'nullable|array',
            'amenity_ids.*' => 'exists:amenities,id',
        ]);

        // Generate slug from name
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Park::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Generate slug_path from location data
        $slugPath = collect([
            $validated['country'] ?? null,
            $validated['state'] ?? null,
            $validated['city'] ?? null,
            $validated['name'],
        ])->filter()->map(fn($part) => Str::slug($part))->implode('-');

        $park = Park::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'slug_path' => $slugPath,
            'description' => $validated['description'] ?? null,
            'short_description' => $validated['short_description'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'country' => $validated['country'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'website_url' => $validated['website_url'] ?? null,
            'main_image_url' => $validated['main_image_url'] ?? null,
            'status' => $validated['status'] ?? 'active',
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        // Attach amenities if provided
        if (!empty($validated['amenity_ids'])) {
            $park->amenities()->sync($validated['amenity_ids']);
        }

        return response()->json([
            'message' => 'Park created successfully',
            'park' => $park->load('amenities'),
        ], 201);
    }

    /**
     * Search/lookup parks by name, state, or ID.
     * GET /api/parks/search?q=pioneer&state=california&limit=10
     */
    public function search(Request $request)
    {
        $query = Park::query();

        if ($request->filled('id')) {
            $park = Park::find($request->id);
            return $park
                ? response()->json(['park' => $park->load('amenities', 'park_photos')])
                : response()->json(['error' => 'Park not found'], 404);
        }

        if ($request->filled('slug')) {
            $park = Park::where('slug', $request->slug)->first();
            return $park
                ? response()->json(['park' => $park->load('amenities', 'park_photos')])
                : response()->json(['error' => 'Park not found'], 404);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('state')) {
            $state = ucwords(str_replace('-', ' ', $request->state));
            $query->where('state', 'like', '%' . $state . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        $limit = min((int) ($request->limit ?? 20), 100);

        $parks = $query->select(['id', 'name', 'slug', 'city', 'state', 'phone', 'website_url', 'enrichment_updated_at'])
            ->orderBy('name')
            ->limit($limit)
            ->get();

        return response()->json(['parks' => $parks, 'count' => $parks->count()]);
    }

    /**
     * Enrich a park with detailed data (rates, facilities, policies, etc.)
     * POST /api/parks/{park}/enrich
     */
    public function enrich(Request $request, Park $park)
    {
        $validated = $request->validate([
            'rates' => 'nullable|array',
            'facilities' => 'nullable|array',
            'site_types' => 'nullable|array',
            'policies' => 'nullable|array',
            'manager_name' => 'nullable|string|max:255',
            'total_sites' => 'nullable|integer|min:0',
            'acreage' => 'nullable|numeric|min:0',
            'reservation_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'website_url' => 'nullable|url|max:255',
            'hours_of_operation' => 'nullable|array',
            'amenity_ids' => 'nullable|array',
            'amenity_ids.*' => 'exists:amenities,id',
            'enrichment_source' => 'nullable|string|max:100',
        ]);

        // Remove amenity_ids before mass update
        $amenityIds = $validated['amenity_ids'] ?? null;
        unset($validated['amenity_ids']);

        // Merge JSON fields instead of replacing (if park already has data)
        foreach (['rates', 'facilities', 'site_types', 'policies'] as $jsonField) {
            if (isset($validated[$jsonField]) && is_array($park->$jsonField)) {
                $validated[$jsonField] = array_merge($park->$jsonField, $validated[$jsonField]);
            }
        }

        $validated['enrichment_updated_at'] = now();

        // Filter out null values so we don't overwrite existing data with null
        $validated = array_filter($validated, fn($v) => $v !== null);

        $park->update($validated);

        if ($amenityIds !== null) {
            $park->amenities()->syncWithoutDetaching($amenityIds);
        }

        return response()->json([
            'message' => 'Park enriched successfully',
            'park' => $park->fresh()->load('amenities'),
        ]);
    }

    /**
     * List available amenities (for enrichment reference)
     * GET /api/amenities
     */
    public function amenities()
    {
        $amenities = \App\Models\Amenity::select(['id', 'amenity', 'category'])->orderBy('category')->orderBy('amenity')->get();
        return response()->json(['amenities' => $amenities]);
    }

    public function update(Request $request, Park $park)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'website_url' => 'nullable|url|max:255',
            'main_image_url' => 'nullable|url|max:255',
            'status' => 'nullable|in:active,inactive',
            'is_featured' => 'nullable|boolean',
            'amenity_ids' => 'nullable|array',
            'amenity_ids.*' => 'exists:amenities,id',
        ]);

        // Update slug if name changed
        if (isset($validated['name']) && $validated['name'] !== $park->name) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;
            while (Park::where('slug', $slug)->where('id', '!=', $park->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;

            // Regenerate slug_path
            $slugPath = collect([
                $validated['country'] ?? $park->country,
                $validated['state'] ?? $park->state,
                $validated['city'] ?? $park->city,
                $validated['name'],
            ])->filter()->map(fn($part) => Str::slug($part))->implode('-');
            $validated['slug_path'] = $slugPath;
        }

        // Remove amenity_ids from validated data before update
        $amenityIds = $validated['amenity_ids'] ?? null;
        unset($validated['amenity_ids']);

        $park->update($validated);

        // Sync amenities if provided
        if ($amenityIds !== null) {
            $park->amenities()->sync($amenityIds);
        }

        return response()->json([
            'message' => 'Park updated successfully',
            'park' => $park->fresh()->load('amenities'),
        ]);
    }
}
