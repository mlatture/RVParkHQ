<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParkRequest;
use App\Models\OverPass;
use App\Models\Park;
use App\Services\OpenAIService;
use App\Services\ParkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParkController extends Controller
{

    public function __construct(
        private readonly parkService $parkService,
        private readonly OpenAIService $OpenAIService,
    ) {
    }

    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['park.view']);

        return view('backend.pages.park.index',[
            'parks' => $this->parkService->getPark(),
        ]);
    }

    public function create()
    {
        $this->checkAuthorization(auth()->user(), ['park.create']);
        return view('backend.pages.park.create');
    }

    public function store(ParkRequest $request)
    {
        $this->checkAuthorization(auth()->user(), ['park.create']);

        $park = new Park();
        $park->name = $request->name;
        $park->name_check_box = $request->change_name == 'on' ? 1 : 0;
        $park->slug = $request->slug ?? null;
        $park->description = $request->description ?? null;
        $park->short_description = $request->short_description ?? null;
        $park->address = $request->address ?? null;
        $park->city = $request->city ?? null;
        $park->state = $request->state ?? null;
        $park->country = $request->country ?? null;
        $park->postal_code = $request->postal_code ?? null;
        $park->latitude = $request->latitude ?? null;
        $park->longitude = $request->longitude ?? null;
        $park->phone = $request->phone ?? null;
        $park->email = $request->email ?? null;
        $park->website_url = $request->website_url ?? null;
        $park->status = $request->status ?? 'inactive';
        $park->is_featured = $request->is_featured == 1 ? true : false;

        if ($request->hasFile('main_image_url')) {
            $path = $request->file('main_image_url')->store('parks', 'public');
            $park->main_image_url = $path;
        }
        
        $park->slug_path = implode('-', array_filter([
            Str::slug($request->country),
            Str::slug($request->state),
            Str::slug($request->city),
            Str::slug($request->name),
        ]));

        $park->save();

        return redirect()->route('admin.parks.index')->with('success', 'Park created successfully.');
    }

    public function edit($id)
    {
        $this->checkAuthorization(auth()->user(), ['park.edit']);
        $park = park::findorFail($id);

        return view('backend.pages.park.edit',[
            'park' => $park,
        ]);

    }

    public function update(ParkRequest $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['park.edit']);
        $park = Park::findOrFail($id);

        $data = [
            'name' => $request->name,
            'name_check_box' => $request->change_name == 'on' ? 1 : 0,
            'slug' => $request->slug,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'phone' => $request->phone,
            'email' => $request->email,
            'website_url' => $request->website_url,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
        ];

        if ($request->hasFile('main_image_url')) {
            if ($park->main_image_url && Storage::disk('public')->exists($park->main_image_url)) {
                Storage::disk('public')->delete($park->main_image_url);
            }

            $data['main_image_url'] = $request->file('main_image_url')->store('parks', 'public');
        }
        
        $data['slug_path'] = implode('-', array_filter([
            Str::slug($request->country),
            Str::slug($request->state),
            Str::slug($request->city),
            Str::slug($request->name),
        ]));

        $park->update($data);

        return redirect()->route('admin.parks.index')->with('success', 'Park updated successfully.');
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['park.delete']);
        $park = park::findorFail($id);
        $park->delete();

        return redirect()->route('admin.parks.index')->with('success', 'Park delete successfully.');
    }

    public function openAi(Request $request)
    {
        $formData = $request->input('formData');
        return $this->OpenAIService->generateParkDescription($formData);
    }

    public function searchPark(Request $request)
    {
        $over_pass = OverPass::where('name', 'like', '%' . $request->search . '%')
            ->select('name', 'state', 'city', 'zip', 'latitude', 'longitude')
            ->get();

        return response()->json([
            'over_pass' => $over_pass,
        ]);
    }
}
