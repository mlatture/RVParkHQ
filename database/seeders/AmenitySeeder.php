<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitySeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('amenities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $amenities = [
            ['amenity' => 'Swimming Pool', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Swimming+Pool', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Swimming+Pool'],
            ['amenity' => 'Heated Swimming Pool', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Heated+Swimming+Pool', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Heated+Swimming+Pool'],
            ['amenity' => 'Lake/Waterfront Access', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Lake%2FWaterfront+Access', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Lake%2FWaterfront+Access'],
            ['amenity' => 'Swimming Beach / Area', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Swimming+Beach+%2F+Area', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Swimming+Beach+%2F+Area'],
            ['amenity' => 'Canoes or Kayaks', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Canoes+or+Kayaks', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Canoes+or+Kayaks'],
            ['amenity' => 'Paddle Boats', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Paddle+Boats', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Paddle+Boats'],
            ['amenity' => 'Fishing', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Fishing', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Fishing'],
            ['amenity' => 'Boat Rentals', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Boat+Rentals', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Boat+Rentals'],
            ['amenity' => 'Boat Ramp / Launch', 'category' => 'Water & Recreation', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Boat+Ramp+%2F+Launch', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Boat+Ramp+%2F+Launch'],
            ['amenity' => 'Volleyball', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Volleyball', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Volleyball'],
            ['amenity' => 'Basketball Court', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Basketball+Court', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Basketball+Court'],
            ['amenity' => 'Horseshoes', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Horseshoes', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Horseshoes'],
            ['amenity' => 'Pickleball', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Pickleball', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Pickleball'],
            ['amenity' => 'Badminton', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Badminton', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Badminton'],
            ['amenity' => 'Tennis Court', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Tennis+Court', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Tennis+Court'],
            ['amenity' => 'Board Games', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Board+Games', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Board+Games'],
            ['amenity' => 'Shuffleboard', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Shuffleboard', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Shuffleboard'],
            ['amenity' => 'Bocce', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Bocce', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Bocce'],
            ['amenity' => 'Laser Tag', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Laser+Tag', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Laser+Tag'],
            ['amenity' => 'Archery', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Archery', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Archery'],
            ['amenity' => 'Mini Golf', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Mini+Golf', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Mini+Golf'],
            ['amenity' => 'Playground', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Playground', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Playground'],
            ['amenity' => 'Game Room / Arcade', 'category' => 'Sports & Games', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Game+Room+%2F+Arcade', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Game+Room+%2F+Arcade'],
            ['amenity' => 'Camp Store', 'category' => 'Convenience & Comfort', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Camp+Store', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Camp+Store'],
            ['amenity' => 'Snack Bar / Concessions', 'category' => 'Convenience & Comfort', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Snack+Bar+%2F+Concessions', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Snack+Bar+%2F+Concessions'],
            ['amenity' => 'Restaurant / Café', 'category' => 'Convenience & Comfort', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Restaurant+%2F+Caf%C3%A9', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Restaurant+%2F+Caf%C3%A9'],
            ['amenity' => 'Laundry Facilities', 'category' => 'Convenience & Comfort', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Laundry+Facilities', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Laundry+Facilities'],
            ['amenity' => 'WiFi Available', 'category' => 'Convenience & Comfort', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=WiFi+Available', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=WiFi+Available'],
            ['amenity' => 'Free WiFi', 'category' => 'Convenience & Comfort', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Free+WiFi', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Free+WiFi'],
            ['amenity' => 'Dump Station', 'category' => 'Convenience & Comfort', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Dump+Station', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Dump+Station'],
            ['amenity' => 'Propane Available', 'category' => 'Convenience & Comfort', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Propane+Available', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Propane+Available'],
            ['amenity' => 'Bathhouses with Showers', 'category' => 'Convenience & Comfort', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Bathhouses+with+Showers', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Bathhouses+with+Showers'],
            ['amenity' => 'Weekend Themed Events', 'category' => 'Experiences & Events', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Weekend+Themed+Events', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Weekend+Themed+Events'],
            ['amenity' => 'Live Music', 'category' => 'Experiences & Events', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Live+Music', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Live+Music'],
            ['amenity' => 'Movie Nights', 'category' => 'Experiences & Events', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Movie+Nights', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Movie+Nights'],
            ['amenity' => 'Campfire Pits / Fire Rings', 'category' => 'Experiences & Events', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Campfire+Pits+%2F+Fire+Rings', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Campfire+Pits+%2F+Fire+Rings'],
            ['amenity' => 'Group Event Facilities', 'category' => 'Experiences & Events', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Group+Event+Facilities', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Group+Event+Facilities'],
            ['amenity' => 'Petting Zoo', 'category' => 'Experiences & Events', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Petting+Zoo', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Petting+Zoo'],
            ['amenity' => 'Nature Trails', 'category' => 'Experiences & Events', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Nature+Trails', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Nature+Trails'],
            ['amenity' => 'Dog Park', 'category' => 'Experiences & Events', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Dog+Park', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Dog+Park'],
            ['amenity' => 'Bounce Pillow / Jump Pad', 'category' => 'Kid & Family Friendly', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Bounce+Pillow+%2F+Jump+Pad', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Bounce+Pillow+%2F+Jump+Pad'],
            ['amenity' => 'Water Slide', 'category' => 'Kid & Family Friendly', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Water+Slide', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Water+Slide'],
            ['amenity' => 'Crafts / Activities', 'category' => 'Kid & Family Friendly', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Crafts+%2F+Activities', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Crafts+%2F+Activities'],
            ['amenity' => 'Hayrides / Wagon Rides', 'category' => 'Kid & Family Friendly', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Hayrides+%2F+Wagon+Rides', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Hayrides+%2F+Wagon+Rides'],
            ['amenity' => 'Pet Friendly', 'category' => 'Other Features', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Pet+Friendly', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Pet+Friendly'],
            ['amenity' => 'Gated Entry', 'category' => 'Other Features', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Gated+Entry', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Gated+Entry'],
            ['amenity' => 'Security Patrol', 'category' => 'Other Features', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Security+Patrol', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Security+Patrol'],
            ['amenity' => 'Cabin Rentals', 'category' => 'Other Features', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Cabin+Rentals', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Cabin+Rentals'],
            ['amenity' => 'Online Reservations', 'category' => 'Other Features', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Online+Reservations', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Online+Reservations'],
            ['amenity' => 'Long-Term / Seasonal Rentals', 'category' => 'Other Features', 'blackicon' => 'https://placehold.co/64x64/000000/FFFFFF?text=Long-Term+%2F+Seasonal+Rentals', 'whiteicon' => 'https://placehold.co/64x64/FFFFFF/000000?text=Long-Term+%2F+Seasonal+Rentals'],
        ];

        DB::table('amenities')->insert($amenities);
    }
}
