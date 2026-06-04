<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Classic Haircut',
            'Fade Cut',
            'Buzz Cut',
            'Beard Trim',
            'Beard Sculpting',
            'Hot Towel Shave',
            'Straight Razor Shave',
            'Hair Styling',
            'Scalp Treatment',
            'Hair Wash & Blow Dry',
            'Kids Haircut',
            'Haircut & Beard Combo',
            'Hair Dye',
            'Line Up',
            'Mohawk',
        ]);

        return [
            'category_id' => ServiceCategory::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->optional()->sentence(),
            'price' => fake()->randomFloat(2, 10, 50),
            'duration' => fake()->randomElement([15, 20, 30, 45, 60]),
            'image' => null,
            'is_active' => true,
        ];
    }
}
