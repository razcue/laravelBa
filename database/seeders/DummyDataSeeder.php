<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create users using the UserFactory
        User::factory()->count(env('DUMMY_DATA_SEEDER_USERS_QUANTITY', 2))
            ->withRole('revisor')->create();

        // Create products using the ProductFactory
        Product::factory()->count(env('DUMMY_DATA_SEEDER_PRODUCTS_QUANTITY', 5))
            ->create();
    }
}
