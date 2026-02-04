<?php

namespace Database\Factories;

use App\Models\Park;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ParkFactory extends Factory
{
    protected $model = Park::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $faker = fake();
        $name = $faker->unique()->company . ' Park';
        $country = $faker->country;
        $state = $faker->state;
        $city = $faker->city;
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $faker->paragraph(3),
            'short_description' => $faker->sentence,
            'address' => $faker->streetAddress,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'postal_code' => $faker->postcode,
            'latitude' => $faker->latitude,
            'longitude' => $faker->longitude,
            'phone' => $faker->phoneNumber,
            'email' => $faker->safeEmail,
            'website_url' => $faker->url,
            'status' => $faker->randomElement(['active', 'inactive']),
            'is_featured' => $faker->boolean(30),
            'main_image_url' => $faker->imageUrl(800, 600, 'nature', true, 'park'),
            'slug_path' => implode('-', array_filter([
                Str::slug($country),
                Str::slug($state),
                Str::slug($city),
                $slug,
            ]))
        ];
    }

}
