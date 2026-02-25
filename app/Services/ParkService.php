<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Amenity;
use App\Models\Country;
use App\Models\Park;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ParkService
{
//    public function getPark()
//    {
//        $query = Park::with('claim_parks');
//        $search = request()->input('search');
//
//        if ($search) {
//            $query->where('name', 'like', "%{$search}%")
//                ->orWhere('city', 'like', "%{$search}%")
//                ->orWhere('email', 'like', "%{$search}%");
//        }
//
//
//        return $query->latest()->paginate(config('settings.default_pagination') ?? 10);
//    }

    public function getPark()
    {
        $query = Park::with('claim_parks');
        $search = request()->input('search');

        if (Auth::check() && Auth::user()->hasRole(['rep', 'Rep'])) {
            $userEmail = Auth::user()->email;
            $query->where('rep', $userEmail);
        }

        // Search filters
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(config('settings.default_pagination') ?? 10);
    }


    public function getParkDetails($slug_path)
    {
        $park = Park::with('winnerParks', 'amenities', 'claim_parks', 'park_photos')->where('slug_path', $slug_path)->firstOrFail();
        $reviews = Review::where(['park_id' => $park->id, 'status' => 'confirmed'])->latest()->limit(10)->get();
        $approvedClaim = $park->claim_parks->where('status', 'approved')->first();
        return compact('park', 'reviews', 'approvedClaim');
    }

    public function getFilteredParks(array $filters, int $perPage = 12): array
    {
        $parks = Park::query()->filter($filters)->with(['claim_parks' => function($query) {
            $query->where('status', 'approved');
        }, 'cover_photo'])->paginate($perPage)->withQueryString();

        // Add site availability data to each park from approved claim
        $parks->getCollection()->transform(function($park) {
            $approvedClaim = $park->claim_parks->first();
            if ($approvedClaim) {
                // Add site availability fields to the park object
                $siteFields = [
                    'sites_50amp_full',
                    'sites_30amp_full',
                    'sites_30amp_water_electric',
                    'sites_50amp_water_electric',
                    'sites_30amp_electric',
                    'sites_50amp_electric',
                    'sites_dry_camping',
                    'tent_sites_utilities',
                    'tent_sites_primitive',
                    'seasonal_sites',
                    'group_campsites'
                ];

                foreach ($siteFields as $field) {
                    $park->$field = $approvedClaim->$field ?? 0;
                }
            } else {
                // Set default values if no approved claim
                $siteFields = [
                    'sites_50amp_full',
                    'sites_30amp_full',
                    'sites_30amp_water_electric',
                    'sites_50amp_water_electric',
                    'sites_30amp_electric',
                    'sites_50amp_electric',
                    'sites_dry_camping',
                    'tent_sites_utilities',
                    'tent_sites_primitive',
                    'seasonal_sites',
                    'group_campsites'
                ];

                foreach ($siteFields as $field) {
                    $park->$field = 0;
                }
            }
            return $park;
        });

        return [
            'parks' => $parks,
            'states' => Park::select('state')->distinct()->orderBy('state')->get(),
            'country' => Country::select('name')->distinct()->orderBy('name')->get(),
            'amenities' => Amenity::select('id', 'amenity', 'category', 'blackicon', 'whiteicon')->get(),
            'siteFields' => [
                                'sites_50amp_full' => '50 Amp Full Hookup Sites',
                                'sites_30amp_full' => '30 Amp Full Hookup Sites',
                                'sites_30amp_water_electric' => '30 Amp Water & Electric Sites',
                                'sites_50amp_water_electric' => '50 Amp Water & Electric Sites',
                                'sites_30amp_electric' => '30 Amp Electric Only Sites',
                                'sites_50amp_electric' => '50 Amp Electric Only Sites',
                                'sites_dry_camping' => 'No Hookup RV Sites (Dry Camping)',
                                'tent_sites_utilities' => 'Tent Sites (with utilities)',
                                'tent_sites_primitive' => 'Tent Sites (primitive)',
                                'seasonal_sites' => 'Seasonal RV Sites',
                                'group_campsites' => 'Group Campsites',
                            ],
        ];
    }
}
