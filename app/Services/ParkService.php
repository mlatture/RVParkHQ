<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Amenity;
use App\Models\Park;
use App\Models\Review;

class ParkService
{
    public function getPark()
    {
        $query = Park::with('claim_parks');
        $search = request()->input('search');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }


        return $query->latest()->paginate(config('settings.default_pagination') ?? 10);
    }
    
    public function getParkDetails($slug_path)
    {
        $park = Park::with('winnerParks', 'amenities')->where('slug_path', $slug_path)->firstOrFail();
        $approvedClaim = $park->claim_parks->where('status', 'approved')->first();
        $reviews = Review::where(['park_id' => $park->id, 'status' => 'confirmed'])->latest()->limit(10)->get();

        $items = [];
        if($park->rss_url) {
            $rss = simplexml_load_file($park->rss_url);
            if ($rss && isset($rss->channel->item)) {
                foreach ($rss->channel->item as $item) {
                    $items[] = [
                        'title' => (string) $item->title,
                        'link' => (string) $item->link,
                        'description' => (string) $item->description,
                        'author' => (string) $item->children('dc', true)->creator,
                        'pubDate' => (string) $item->pubDate,
                        'comments' => (string) $item->comments,
                    ];
                }
            }
        }
        $park['rss_data'] = $items;
        return compact('park', 'reviews', 'approvedClaim');
    }
    
    public function getFilteredParks(array $filters, int $perPage = 12): array
    {
        return [
            'parks' => Park::query()->filter($filters)->paginate($perPage)->withQueryString(),
            'states' => Park::select('state')->distinct()->orderBy('state')->get(),
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
