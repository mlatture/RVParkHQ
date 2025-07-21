<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AmenityRequest;
use App\Models\Amenity;
use Illuminate\Http\Request;
use App\Services\AmenityService;

class AmenityController extends Controller
{
    protected $service;

    public function __construct(AmenityService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['amenity.view']);
        
        $amenities = $this->service->search($request);
        return view('backend.pages.amenity.index', compact('amenities'));
    }

    public function create()
    {
        $this->checkAuthorization(auth()->user(), ['amenity.create']);

        return view('backend.pages.amenity.create');
    }

    public function store(AmenityRequest $request)
    {
        $this->checkAuthorization(auth()->user(), ['amenity.create']);
         
        $this->service->create($request->validated());
        return redirect()->route('admin.amenities.index')->with('success', 'Amenity created successfully.');
    }

    public function edit($id)
    {
        $this->checkAuthorization(auth()->user(), ['amenity.edit']);
        
        $amenity = Amenity::findOrFail($id);
        return view('backend.pages.amenity.edit', compact('amenity'));
    }

    public function update(AmenityRequest $request, Amenity $amenity)
    {
        $this->checkAuthorization(auth()->user(), ['amenity.edit']);
        
        $this->service->update($amenity, $request->validated());
        return redirect()->route('admin.amenities.index')->with('success', 'Amenity updated successfully.');
    }

    public function destroy(Amenity $amenity)
    {
        $this->checkAuthorization(auth()->user(), ['amenity.delete']);
        
        $this->service->delete($amenity);
        return redirect()->route('admin.amenities.index')->with('success', 'Amenity deleted successfully.');
    }
}
