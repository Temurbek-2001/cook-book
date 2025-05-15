<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\Favorite;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User 6',
            'email' => 'test6@example.com',
        ]);
        $this->call([
            CategorySeeder::class,
            RecipeSeeder::class,
            FavoriteSeeder::class,
        ]);
    }
}
