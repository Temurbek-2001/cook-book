<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        Favorite::factory()->count(50)->create();
    }
}