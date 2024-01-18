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
        // Create 5 users using the UserFactory
        User::factory()->withRole('manager')->create();
        User::factory()->count(4)->withRole('revisor')->create();

        // Create 25 products using the ProductFactory
        Product::factory()->count(25)->create();
    }
}
