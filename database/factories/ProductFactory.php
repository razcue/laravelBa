<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imagePath = fake()->image();
        $filename = null;
        if ($imagePath) {
            $filename = time() . '_' . Str::random(10) . '.jpg';
            $destinationPath = public_path('images/' . $filename);
            rename($imagePath, $destinationPath);
        }

        return [
            'image' => $filename,
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 0, 100),
        ];
    }
}
