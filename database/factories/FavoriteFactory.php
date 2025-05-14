<?php

namespace Database\Factories;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'recipe_id' => Recipe::factory(),
        ];
    }
}