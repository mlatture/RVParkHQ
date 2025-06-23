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
        $name = $this->faker->unique()->company . ' Park';
        $country = $this->faker->country;
        $state = $this->faker->state;
        $city = $this->faker->city;
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->paragraph(3),
            'short_description' => $this->faker->sentence,
            'address' => $this->faker->streetAddress,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'postal_code' => $this->faker->postcode,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'website_url' => $this->faker->url,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'is_featured' => $this->faker->boolean(30),
            'main_image_url' => $this->faker->imageUrl(800, 600, 'nature', true, 'park'),
            'slug_path' => implode('-', array_filter([
                Str::slug($country),
                Str::slug($state),
                Str::slug($city),
                $slug,
            ]))
        ];
    }

}
