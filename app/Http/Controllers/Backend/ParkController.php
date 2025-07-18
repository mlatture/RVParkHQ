<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParkRequest;
use App\Mail\ClaimParkConfirmationMail;
use App\Models\OverPass;
use App\Models\Park;
use App\Models\ClaimPark;
use App\Models\Amenity;
use App\Services\OpenAIService;
use App\Services\ParkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Contracts\Encryption\DecryptException;

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

        $amenities = Amenity::select('id','amenity', 'category', 'blackicon', 'whiteicon')->get();

        return view('backend.pages.park.create', compact('amenities'));
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
        $park->request_park = $request->request_park == "on" ? 1 : 0;

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

        $park->amenities()->sync($request->amenities);

        return redirect()->route('admin.parks.index')->with('success', 'Park created successfully.');
    }

    public function edit($id)
    {
        $this->checkAuthorization(auth()->user(), ['park.edit']);
        $park = Park::with('amenities')->findOrFail($id);
        $user = auth()->user();
        if (!$user->hasRole('Superadmin')) {
            $hasClaimedPark = ClaimPark::where('park_id', $park->id)
                ->where('user_id', $user->id)
                ->where('status', 'approved')
                ->exists();
                
            if (!$hasClaimedPark) {
                return redirect()->route('admin.parks.index')
                    ->with('error', 'Unauthorized access. You do not have permission to access this park.');
            }
        }
        $amenities = Amenity::select('id', 'amenity', 'category', 'blackicon', 'whiteicon')->get();
        return view('backend.pages.park.edit', [
            'park' => $park,
            'amenities' => $amenities,
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
            'request_park' => $request->request_park == 'on' ? 1 : 0,
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
        $park->amenities()->sync($request->amenities);
        
        Mail::to(config('mail.notification_email'))->send(new \App\Mail\ParkUpdatedMail($park, auth()->user()));

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

    public function applyClamPark($id)
    {
        try {
            $park_id = decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->route('admin.parks.index')->with([
                'icon' => 'error',
                'message' => 'Invalid park ID or expired link.',
            ]);
        }

        $park = Park::findorFail(decrypt($id));
        $claim_check = ClaimPark::where('park_id', $park->id)->where('status', 'approved')->first();
        if ($claim_check) {
            return redirect()->back()->with('error', 'A claim for this park is already approved.');
        }

        return view('backend.pages.park.applyClamPark', compact('park'));
    }

    public function storeClamPark(Request $request)
    {
        $validated = $request->validate([
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_role' => 'nullable|string|max:100',
            'is_owner_or_manager' => 'required|boolean',

            // Park Information
            'park_id' => 'required',
            'booking_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',

            // Site Inventory
            'sites_50amp_full' => 'nullable|integer|min:0',
            'sites_30amp_full' => 'nullable|integer|min:0',
            'sites_30amp_water_electric' => 'nullable|integer|min:0',
            'sites_50amp_water_electric' => 'nullable|integer|min:0',
            'sites_30amp_electric' => 'nullable|integer|min:0',
            'sites_50amp_electric' => 'nullable|integer|min:0',
            'sites_dry_camping' => 'nullable|integer|min:0',
            'tent_sites_utilities' => 'nullable|integer|min:0',
            'tent_sites_primitive' => 'nullable|integer|min:0',
            'seasonal_sites' => 'nullable|integer|min:0',
            'group_campsites' => 'nullable|integer|min:0',

            // Cabins & Rentals
            'deluxe_cabins' => 'nullable|integer|min:0',
            'primitive_cabins' => 'nullable|integer|min:0',
            'yurts_glamping' => 'nullable|integer|min:0',
            'other_rentals' => 'nullable|string|max:500',

            // Waterfront & Marina
            'boat_slips' => 'nullable|integer|min:0',
            'canoe_kayak_rental' => 'nullable|boolean',
            'paddle_boats' => 'nullable|boolean',
            'boat_ramp' => 'nullable|boolean',
            'fishing_available' => 'nullable|boolean',

            // Reservation System
            'reservation_provider' => 'nullable|string|max:100',
            'happy_with_provider' => 'nullable|boolean',
            'contact_about_reservation' => 'nullable|boolean',

            // Amenities and Media
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('claim-parks/logos', 'public');
        }

        $photosData = [];
        if ($request->hasFile('park_photos')) {
            foreach ($request->file('park_photos') as $photo) {
                $path = $photo->store('claim-parks/park_photos', 'public');
                $photosData[] = [
                    'path' => $path,
                    'original_name' => $photo->getClientOriginalName(),
                    'size' => $photo->getSize(),
                    'uploaded_at' => now()->toDateTimeString()
                ];
            }
        }

        // Create the claim
        $claim = ClaimPark::create([
            // Contact Information
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_role' => $request->contact_role,
            'is_owner_or_manager' => $request->is_owner_or_manager,

            // Park Information
            'park_id' => $request->park_id,
            'user_id' => $request->user()->id,
            'booking_url' => $request->booking_url,
            'facebook_url' => $request->facebook_url,
            'instagram_url' => $request->instagram_url,

            // Site Inventory
            'sites_50amp_full' => $request->sites_50amp_full ?? 0,
            'sites_30amp_full' => $request->sites_30amp_full ?? 0,
            'sites_30amp_water_electric' => $request->sites_30amp_water_electric ?? 0,
            'sites_50amp_water_electric' => $request->sites_50amp_water_electric ?? 0,
            'sites_30amp_electric' => $request->sites_30amp_electric ?? 0,
            'sites_50amp_electric' => $request->sites_50amp_electric ?? 0,
            'sites_dry_camping' => $request->sites_dry_camping ?? 0,
            'tent_sites_utilities' => $request->tent_sites_utilities ?? 0,
            'tent_sites_primitive' => $request->tent_sites_primitive ?? 0,
            'seasonal_sites' => $request->seasonal_sites ?? 0,
            'group_campsites' => $request->group_campsites ?? 0,

            // Cabins & Rentals
            'deluxe_cabins' => $request->deluxe_cabins ?? 0,
            'primitive_cabins' => $request->primitive_cabins ?? 0,
            'yurts_glamping' => $request->yurts_glamping ?? 0,
            'other_rentals' => $request->other_rentals,

            // Waterfront & Marina
            'boat_slips' => $request->boat_slips ?? 0,
            'canoe_kayak_rental' => $request->canoe_kayak_rental ?? false,
            'paddle_boats' => $request->paddle_boats ?? false,
            'boat_ramp' => $request->boat_ramp ?? false,
            'fishing_available' => $request->fishing_available ?? false,

            // Reservation System
            'reservation_provider' => $request->reservation_provider,
            'happy_with_provider' => $request->happy_with_provider,
            'contact_about_reservation' => $request->contact_about_reservation ?? false,

            // Media Storage
            'amenities' => $request->amenities ? json_encode($request->amenities) : null,
            'images' => !empty($photosData) ? json_encode($photosData) : null,
            'logo_path' => $logoPath,

            // Status
            'status' => 'pending'
        ]);

        Mail::to(config('mail.notification_email'))->send(new ClaimParkConfirmationMail($claim));

        return redirect()->route('admin.parks.index')
            ->with('success', 'Park claim submitted successfully!');
    }
}
