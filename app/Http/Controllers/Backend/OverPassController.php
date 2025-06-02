<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampgroundRequest;
use App\Models\OverPass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OverPassController extends Controller
{
    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['campground.view']);

        $search = request()->input('search');

        $query = OverPass::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%")
                ->orWhere('zip', 'like', "%{$search}%")
                ->orWhere('state', 'like', "%{$search}%");
        }

        $campgrounds = $query->orderBy('name', 'ASC')->paginate(config('settings.default_pagination') ?? 10);

        return view('backend.pages.campground.index', compact('campgrounds'));
    }

    public function create()
    {
        $this->checkAuthorization(auth()->user(), ['campground.create']);
        return view('backend.pages.campground.create');
    }

    public function store(CampgroundRequest $request)
    {
        $this->checkAuthorization(auth()->user(), ['campground.create']);

        $data = $request->only(['name', 'state', 'city', 'zip', 'latitude', 'longitude']);
        $campground = OverPass::create($data);

        return redirect()->route('admin.campground.index')->with('success', 'Campground saved successfully!');

    }

    public function edit($id)
    {
        $this->checkAuthorization(auth()->user(), ['campground.edit']);
        $campgrounds = OverPass::findorFail($id);
        return view('backend.pages.campground.edit', compact('campgrounds'));
    }

    public function update(CampgroundRequest $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['campground.edit']);

        $campground = OverPass::findOrFail($id);
        $campground->name = $request->name;
        $campground->state = $request->state;
        $campground->city = $request->city;
        $campground->zip = $request->zip;
        $campground->latitude = $request->latitude;
        $campground->longitude = $request->longitude;
        $campground->save();

        return redirect()->route('admin.campground.index')
            ->with('success', 'Campground updated successfully.');
    }


    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['campground.delete']);

        $over_pass = OverPass::findorFail($id);
        $over_pass->delete();

        return redirect()->route('admin.campground.index')->with('success', 'Campground delete successfully.');
    }

    public function importCreate()
    {
        $this->checkAuthorization(auth()->user(), ['campground.create']);
        return view('backend.pages.campground.import');
    }

    public function fetchCampgroundsByState(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['campground.create']);

        $state = str_replace(['_', '-'], ' ', $request->state_name);
        $stateName = ucwords(strtolower($state));

        $query = <<<EOT
[out:json][timeout:60];
area["name"="$stateName"]["admin_level"="4"]->.searchArea;
(
  node["tourism"="camp_site"](area.searchArea);
  node["camp_site"="caravan_site"](area.searchArea);
  way["tourism"="camp_site"](area.searchArea);
  way["camp_site"="caravan_site"](area.searchArea);
  relation["tourism"="camp_site"](area.searchArea);
  relation["camp_site"="caravan_site"](area.searchArea);
);
out center tags;
EOT;

        $response = Http::timeout(60)->asForm()->post('http://overpass-api.de/api/interpreter', [
            'data' => $query
        ]);

        if (!$response->successful()) {
            return response()->json(['status' => false, 'message' => 'Failed to fetch data'], 500);
        }

        $data = $response->json();
        $campgrounds = [];

        foreach ($data['elements'] ?? [] as $el) {
            $tags = $el['tags'] ?? [];

            $name = $tags['name'] ?? null;
            $city = $tags['addr:city'] ?? null;
            $state = $tags['addr:state'] ?? $stateName;
            $postcode = $tags['addr:postcode'] ?? null;
            $lat = $el['lat'] ?? ($el['center']['lat'] ?? null);
            $lon = $el['lon'] ?? ($el['center']['lon'] ?? null);

            if ($name && $lat && $lon) {
                $campgrounds[] = [
                    'name' => $name,
                    'city' => $city,
                    'state' => $state,
                    'region' => $stateName,
                    'zip' => $postcode,
                    'latitude' => $lat,
                    'longitude' => $lon,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (count($campgrounds) > 0) {

            OverPass::where('region', $stateName)->delete();
            OverPass::insert($campgrounds);

            return response()->json([
                'status' => true,
                'message' => 'Campgrounds fetched and saved successfully.',
                'count' => count($campgrounds),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "No campground data found for '{$stateName}'.",
                'count' => 0,
            ]);
        }
    }
}
