<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public function run()
    {
        $amenities = [
            ['amenity' => 'Swimming Pool', 'category' => 'Water & Recreation', 'blackicon' => 'amenities/icons/black/swimmingpool-black.png', 'whiteicon' => 'amenities/icons/white/swimmingpool-white.png'],
            ['amenity' => 'Heated Swimming Pool', 'category' => 'Water & Recreation', 'blackicon' => 'amenities/icons/black/heatedpool-black.png', 'whiteicon' => 'amenities/icons/white/heatedpool-white.png'],
            ['amenity' => 'Lake/Waterfront Access', 'category' => 'Water & Recreation', 'blackicon' => 'amenities/icons/black/lake-black.png', 'whiteicon' => 'amenities/icons/white/lake-white.png'],
            ['amenity' => 'Swimming Beach / Area', 'category' => 'Water & Recreation', 'blackicon' => 'amenities/icons/black/beach-black.png', 'whiteicon' => 'amenities/icons/white/beach-white.png'],
            ['amenity' => 'Canoes or Kayaks', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Canoes+or+Kayaks', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Canoes+or+Kayaks'],
            ['amenity' => 'Paddle Boats', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Paddle+Boats', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Paddle+Boats'],
            ['amenity' => 'Fishing', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Fishing', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Fishing'],
            ['amenity' => 'Boat Rentals', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Boat+Rentals', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Boat+Rentals'],
            ['amenity' => 'Boat Ramp / Launch', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Boat+Ramp+%2F+Launch', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Boat+Ramp+%2F+Launch'],
            ['amenity' => 'Volleyball', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/volleyball-black.png', 'whiteicon' => 'amenities/icons/white/volleyball-white.png'],
            ['amenity' => 'Basketball Court', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/basketballcourt-black.png', 'whiteicon' => 'amenities/icons/white/basketballcourt-white.png'],
            ['amenity' => 'Horseshoes', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/horseshoe-black.png', 'whiteicon' => 'amenities/icons/white/horseshoe-white.png'],
            ['amenity' => 'Pickleball', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/pickleball-black.png', 'whiteicon' => 'amenities/icons/white/pickleball-white.png'],
            ['amenity' => 'Badminton', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/badminton-black.png', 'whiteicon' => 'amenities/icons/white/badminton-white.png'],
            ['amenity' => 'Tennis Court', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/tennis-black.png', 'whiteicon' => 'amenities/icons/white/tennis-white.png'],
            ['amenity' => 'Board Games', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Board+Games', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Board+Games'],
            ['amenity' => 'Shuffleboard', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Shuffleboard', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Shuffleboard'],
            ['amenity' => 'Bocce', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/bocce-black.png', 'whiteicon' => 'amenities/icons/white/bocce-white.png'],
            ['amenity' => 'Laser Tag', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/lasertag-black.png', 'whiteicon' => 'amenities/icons/white/lasertag-white.png'],
            ['amenity' => 'Archery', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/archery-black.png', 'whiteicon' => 'amenities/icons/white/archery-white.png'],
            ['amenity' => 'Mini Golf', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/minigolf-black.png', 'whiteicon' => 'amenities/icons/white/minigolf-white.png'],
            ['amenity' => 'Playground', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/playground-black.png', 'whiteicon' => 'amenities/icons/white/playground-white.png'],
            ['amenity' => 'Game Room / Arcade', 'category' => 'Sports & Games', 'blackicon' => 'amenities/icons/black/arcade-black.png', 'whiteicon' => 'amenities/icons/white/arcade-white.png'],
            ['amenity' => 'Camp Store', 'category' => 'Convenience & Comfort', 'blackicon' => 'amenities/icons/black/campstore-black.png', 'whiteicon' => 'amenities/icons/white/campstore-white.png'],
            ['amenity' => 'Snack Bar / Concessions', 'category' => 'Convenience & Comfort', 'blackicon' => 'amenities/icons/black/snackbar-black.png', 'whiteicon' => 'amenities/icons/white/snackbar-white.png'],
            ['amenity' => 'Restaurant / Café', 'category' => 'Convenience & Comfort', 'blackicon' => 'amenities/icons/black/cafe-black.png', 'whiteicon' => 'amenities/icons/white/cafe-white.png'],
            ['amenity' => 'Laundry Facilities', 'category' => 'Convenience & Comfort', 'blackicon' => 'amenities/icons/black/laundryfacilities-black.png', 'whiteicon' => 'amenities/icons/white/laundryfacilities-white.png'],
            ['amenity' => 'WiFi Available', 'category' => 'Convenience & Comfort', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=WiFi+Available', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=WiFi+Available'],
            ['amenity' => 'Free WiFi', 'category' => 'Convenience & Comfort', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Free+WiFi', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Free+WiFi'],
            ['amenity' => 'Dump Station', 'category' => 'Convenience & Comfort', 'blackicon' => 'amenities/icons/black/dumpstation-black.png', 'whiteicon' => 'amenities/icons/white/dumpstation-white.png'],
            ['amenity' => 'Propane Available', 'category' => 'Convenience & Comfort', 'blackicon' => 'amenities/icons/black/propane-black.png', 'whiteicon' => 'amenities/icons/white/propane-white.png'],
            ['amenity' => 'Bathhouses with Showers', 'category' => 'Convenience & Comfort', 'blackicon' => 'amenities/icons/black/shower-black.png', 'whiteicon' => 'amenities/icons/white/shower-white.png'],
            ['amenity' => 'Weekend Themed Events', 'category' => 'Experiences & Events', 'blackicon' => 'amenities/icons/black/themedevents-black.png', 'whiteicon' => 'amenities/icons/white/themedevents-white.png'],
            ['amenity' => 'Live Music', 'category' => 'Experiences & Events', 'blackicon' => 'amenities/icons/black/livemusic-black.png', 'whiteicon' => 'amenities/icons/white/livemusic-white.png'],
            ['amenity' => 'Movie Nights', 'category' => 'Experiences & Events', 'blackicon' => 'amenities/icons/black/movienight-black.png', 'whiteicon' => 'amenities/icons/white/movienight-white.png'],
            ['amenity' => 'Campfire Pits / Fire Rings', 'category' => 'Experiences & Events', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Campfire+Pits+%2F+Fire+Rings', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Campfire+Pits+%2F+Fire+Rings'],
            ['amenity' => 'Group Event Facilities', 'category' => 'Experiences & Events', 'blackicon' => 'amenities/icons/black/groupeventsfacilities-black.png', 'whiteicon' => 'amenities/icons/white/groupeventsfacilities-white.png'],
            ['amenity' => 'Petting Zoo', 'category' => 'Experiences & Events', 'blackicon' => 'amenities/icons/black/pettingzoo-black.png', 'whiteicon' => 'amenities/icons/white/pettingzoo-white.png'],
            ['amenity' => 'Nature Trails', 'category' => 'Experiences & Events', 'blackicon' => 'amenities/icons/black/naturetrails-black.png', 'whiteicon' => 'amenities/icons/white/naturetrails-white.png'],
            ['amenity' => 'Dog Park', 'category' => 'Experiences & Events', 'blackicon' => 'amenities/icons/black/dogpark-black.png', 'whiteicon' => 'amenities/icons/white/dogpark-white.png'],
            ['amenity' => 'Bounce Pillow / Jump Pad', 'category' => 'Kid & Family Friendly', 'blackicon' => 'amenities/icons/black/bouncepillow-black.png', 'whiteicon' => 'amenities/icons/white/bouncepillow-white.png'],
            ['amenity' => 'Water Slide', 'category' => 'Kid & Family Friendly', 'blackicon' => 'amenities/icons/black/waterslide-black.png', 'whiteicon' => 'amenities/icons/white/waterslide-white.png'],
            ['amenity' => 'Crafts / Activities', 'category' => 'Kid & Family Friendly', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Crafts+%2F+Activities', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Crafts+%2F+Activities'],
            ['amenity' => 'Hayrides / Wagon Rides', 'category' => 'Kid & Family Friendly', 'blackicon' => 'amenities/icons/black/hayrides-black.png', 'whiteicon' => 'amenities/icons/white/hayrides-white.png'],
            ['amenity' => 'Pet Friendly', 'category' => 'Other Features', 'blackicon' => 'amenities/icons/black/petfriendly-black.png', 'whiteicon' => 'amenities/icons/white/petfriendly-white.png'],
            ['amenity' => 'Gated Entry', 'category' => 'Other Features', 'blackicon' => 'amenities/icons/black/gatedentry-black.png', 'whiteicon' => 'amenities/icons/white/gatedentry-white.png'],
            ['amenity' => 'Security Patrol', 'category' => 'Other Features', 'blackicon' => 'amenities/icons/black/securitypatrol-black.png', 'whiteicon' => 'amenities/icons/white/securitypatrol-white.png'],
            ['amenity' => 'Cabin Rentals', 'category' => 'Other Features', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Cabin+Rentals', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Cabin+Rentals'],
            ['amenity' => 'Online Reservations', 'category' => 'Other Features', 'blackicon' => 'amenities/icons/black/onlinereservation-black.png', 'whiteicon' => 'amenities/icons/white/onlinereservation-white.png'],
            ['amenity' => 'Long-Term / Seasonal Rentals', 'category' => 'Other Features', 'blackicon' => 'amenities/icons/black/seasonalrental-black.png', 'whiteicon' => 'amenities/icons/white/seasonalrental-white.png'],
            ['amenity' => '55+ Community', 'category' => 'Other Features', 'blackicon' => 'amenities/icons/black/55+-black.png', 'whiteicon' => 'amenities/icons/white/55+-white.png'],
            ['amenity' => 'Adults Only', 'category' => 'Other Features', 'blackicon' => 'amenities/icons/black/adultsonly-black.png', 'whiteicon' => 'amenities/icons/white/adultsonly-white.png'],
            ['amenity' => 'Organized Activities', 'category' => 'Other Features', 'blackicon' => 'amenities/icons/black/organizedactivities-black.png', 'whiteicon' => 'amenities/icons/white/organizedactivities-white.png'],
            ['amenity' => 'Clothing Optional', 'category' => 'Other Features', 'blackicon' => 'amenities/icons/black/clothing-black.png', 'whiteicon' => 'amenities/icons/white/clothing-white.png'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::updateOrCreate(
                ['amenity' => $amenity['amenity']],
                [
                    'category' => $amenity['category'],
                    'blackicon' => $amenity['blackicon'],
                    'whiteicon' => $amenity['whiteicon'],
                ]
            );
        }
    }
}
