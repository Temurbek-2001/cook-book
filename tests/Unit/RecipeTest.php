<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $recipe = new Recipe();

        $this->assertEquals([
            'title',
            'description',
            'ingredients',
            'instructions',
            'preparation_time',
            'cooking_time',
            'difficulty_level',
            'image_path',
            'user_id',
            'category_id',
        ], $recipe->getFillable());
    }

    /** @test */
    public function it_casts_ingredients_to_array()
    {
        $recipe = Recipe::factory()->create([
            'ingredients' => ['flour', 'sugar', 'eggs'],
        ]);

        $this->assertIsArray($recipe->ingredients);
        $this->assertContains('sugar', $recipe->ingredients);
    }

    /** @test */
    public function it_belongs_to_a_category()
    {
        $category = Category::factory()->create();
        $recipe = Recipe::factory()->create(['category_id' => $category->id]);

        $this->assertTrue($recipe->category->is($category));
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($recipe->user->is($user));
    }

    /** @test */
    public function it_can_be_favorited_by_users()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create();

        $recipe->favorites()->attach($user->id);

        $this->assertTrue($recipe->favorites->contains($user));
    }

    /** @test */
    public function it_returns_true_if_favorited_by_user()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create();

        $recipe->favorites()->attach($user->id);

        $this->assertTrue($recipe->isFavoritedBy($user));
    }

    /** @test */
    public function it_returns_false_if_not_favorited_by_user()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create();

        $this->assertFalse($recipe->isFavoritedBy($user));
    }

    /** @test */
    public function it_calculates_total_time_correctly()
    {
        $recipe = Recipe::factory()->create([
            'preparation_time' => 10,
            'cooking_time' => 20,
        ]);

        $this->assertEquals(30, $recipe->total_time);
    }

    /** @test */
    public function it_returns_correct_favorites_count()
    {
        $users = User::factory()->count(3)->create();
        $recipe = Recipe::factory()->create();

        $recipe->favorites()->attach($users->pluck('id'));

        $this->assertEquals(3, $recipe->favorites_count);
    }
}
