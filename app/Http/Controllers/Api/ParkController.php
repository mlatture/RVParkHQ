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
