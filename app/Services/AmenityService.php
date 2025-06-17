<?php

namespace App\Services;

use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AmenityService
{
    public function search(Request $request)
    {
        return Amenity::search($request->input('search'))->paginate(10);
    }

    public function create(array $data)
    {
        if (isset($data['blackicon']) && $data['blackicon'] instanceof \Illuminate\Http\UploadedFile) {
            $data['blackicon'] = $data['blackicon']->store('amenities/icons/black', 'public');
        }

        if (isset($data['whiteicon']) && $data['whiteicon'] instanceof \Illuminate\Http\UploadedFile) {
            $data['whiteicon'] = $data['whiteicon']->store('amenities/icons/white', 'public');
        }

        return Amenity::create([
            'amenity'    => $data['amenity'],
            'category'   => $data['category'],
            'blackicon'  => $data['blackicon'] ?? null,
            'whiteicon'  => $data['whiteicon'] ?? null,
        ]);
    }

    public function update(Amenity $amenity, array $data)
    {
        $amenity->amenity = $data['amenity'];
        $amenity->category = $data['category'];

        if (isset($data['blackicon']) && $data['blackicon'] instanceof \Illuminate\Http\UploadedFile) {
            if ($amenity->blackicon && Storage::exists('public/' . $amenity->blackicon)) {
                Storage::delete('public/' . $amenity->blackicon);
            }
            $amenity->blackicon = $data['blackicon']->store('amenities/icons/black', 'public');
        }

        if (isset($data['whiteicon']) && $data['whiteicon'] instanceof \Illuminate\Http\UploadedFile) {
            if ($amenity->whiteicon && Storage::exists('public/' . $amenity->whiteicon)) {
                Storage::delete('public/' . $amenity->whiteicon);
            }
            $amenity->whiteicon = $data['whiteicon']->store('amenities/icons/white', 'public');
        }

        $amenity->save();

        return $amenity;
    }

    public function delete(Amenity $amenity)
    {
        if ($amenity->blackicon && Storage::exists('public/' . $amenity->blackicon)) {
            Storage::delete('public/' . $amenity->blackicon);
        }

        if ($amenity->whiteicon && Storage::exists('public/' . $amenity->whiteicon)) {
            Storage::delete('public/' . $amenity->whiteicon);
        }

        return $amenity->delete();
    }
}
