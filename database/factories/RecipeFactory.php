<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'ingredients' => json_encode($this->faker->words(10)),
            'instructions' => $this->faker->paragraph(5),
            'preparation_time' => $this->faker->numberBetween(5, 60),
            'cooking_time' => $this->faker->numberBetween(10, 120),
            'difficulty_level' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'image_path' => $this->faker->imageUrl(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}