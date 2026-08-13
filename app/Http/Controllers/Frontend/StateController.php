<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StateController extends Controller
{
    /**
     * Browse all states grouped by region.
     */
    public function index(Request $request)
    {
        $states = collect(config('states.list'));

        if ($request->filled('search')) {
            $search = Str::lower($request->input('search'));
            $states = $states->filter(function ($state) use ($search) {
                return Str::contains(Str::lower($state['name']), $search)
                    || Str::contains(Str::lower($state['abbr']), $search)
                    || Str::contains(Str::lower($state['region']), $search);
            });
        }

        // Get park counts per state using defaultSearch scope
        $parkCounts = Park::query()
            ->defaultSearch()
            ->where('status', 'active')
            ->selectRaw('state, COUNT(*) as count')
            ->groupBy('state')
            ->pluck('count', 'state');

        // Attach counts to states
        $states = $states->map(function ($state) use ($parkCounts) {
            $state['park_count'] = $parkCounts->get($state['name'], 0);

            return $state;
        });

        // Group by region
        $regions = $states->groupBy('region');

        $totalParks = $parkCounts->sum();

        return view('frontend.pages.campgrounds.index', compact('regions', 'totalParks'));
    }

    /**
     * Show parks for a single state.
     */
    public function show(Request $request, string $stateSlug)
    {
        $states = collect(config('states.list'));
        $stateInfo = $states->firstWhere('slug', $stateSlug);

        if (! $stateInfo) {
            abort(404);
        }

        $stateName = $stateInfo['name'];

        // Build query
        $query = Park::query()->where('status', 'active');

        // Default search behavior with toggles
        if (! $request->has('include_federal')) {
            $query->excludeFederal();
        }
        if (! $request->has('include_harvest_hosts')) {
            $query->excludeHarvestHosts();
        }

        $query->where('state', $stateName);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Amenity filter
        if ($request->filled('amenity')) {
            $amenityIds = (array) $request->input('amenity');
            $query->whereHas('amenities', function ($q) use ($amenityIds) {
                $q->whereIn('amenities.id', $amenityIds);
            });
        }

        // Sort
        $sort = $request->input('sort', 'name');
        switch ($sort) {
            case 'rating':
                $query->orderByDesc('google_rating');
                break;
            case 'city':
                $query->orderBy('city');
                break;
            default:
                $query->orderBy('name');
        }

        $parks = $query->with('amenities')->paginate(24)->appends($request->query());

        // Stats
        $statsQuery = Park::query()->where('status', 'active')->defaultSearch()->where('state', $stateName);
        $totalParks = $statsQuery->count();

        $topCities = Park::query()->where('status', 'active')->defaultSearch()
            ->where('state', $stateName)
            ->selectRaw('city, COUNT(*) as count')
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'city');

        $topAmenities = Amenity::query()
            ->whereHas('parks', function ($q) use ($stateName) {
                $q->where('status', 'active')->defaultSearch()->where('state', $stateName);
            })
            ->withCount(['parks' => function ($q) use ($stateName) {
                $q->where('status', 'active')->defaultSearch()->where('state', $stateName);
            }])
            ->orderByDesc('parks_count')
            ->limit(8)
            ->get();

        // All amenities for filter
        $amenities = Amenity::orderBy('amenity')->get();

        // First park image for OG
        $ogImage = $parks->first()?->main_image_url;

        return view('frontend.pages.campgrounds.show', compact(
            'stateInfo', 'stateName', 'parks', 'totalParks',
            'topCities', 'topAmenities', 'amenities', 'ogImage'
        ));
    }
}
