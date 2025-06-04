<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_displays_the_favorites_index_page_for_authenticated_user()
    {
        $category = Category::factory()->create();
        $recipe = Recipe::factory()->create(['category_id' => $category->id]);
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe->id]);

        $response = $this->actingAs($this->user)->get(route('favorites.index'));

        $response->assertStatus(200);
        $response->assertViewIs('favorites.index');
        $response->assertViewHas('favoriteRecipes', function ($favoriteRecipes) {
            return $favoriteRecipes->count() === 1;
        });
        $response->assertViewHas('categories', function ($categories) use ($category) {
            return $categories->contains($category);
        });
    }

    /** @test */
    public function it_redirects_unauthenticated_user_from_favorites_index()
    {
        $response = $this->get(route('favorites.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_filters_favorites_by_search_term()
    {
        $category = Category::factory()->create();
        $recipe1 = Recipe::factory()->create(['title' => 'Chocolate Cake', 'category_id' => $category->id]);
        $recipe2 = Recipe::factory()->create(['title' => 'Vanilla Pie', 'category_id' => $category->id]);
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe1->id]);
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe2->id]);

        $response = $this->actingAs($this->user)->get(route('favorites.index', ['search' => 'Chocolate']));

        $response->assertStatus(200);
        $response->assertViewHas('favoriteRecipes', function ($favoriteRecipes) use ($recipe1) {
            return $favoriteRecipes->count() === 1 && $favoriteRecipes->first()->id === $recipe1->id;
        });
    }

    /** @test */
    public function it_filters_favorites_by_category()
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        $recipe1 = Recipe::factory()->create(['category_id' => $category1->id]);
        $recipe2 = Recipe::factory()->create(['category_id' => $category2->id]);
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe1->id]);
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe2->id]);

        $response = $this->actingAs($this->user)->get(route('favorites.index', ['category' => $category1->id]));

        $response->assertStatus(200);
        $response->assertViewHas('favoriteRecipes', function ($favoriteRecipes) use ($recipe1) {
            return $favoriteRecipes->count() === 1 && $favoriteRecipes->first()->id === $recipe1->id;
        });
    }

    /** @test */
    public function it_filters_favorites_by_difficulty()
    {
        $category = Category::factory()->create();
        $recipe1 = Recipe::factory()->create(['difficulty_level' => 'easy', 'category_id' => $category->id]);
        $recipe2 = Recipe::factory()->create(['difficulty_level' => 'hard', 'category_id' => $category->id]);
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe1->id]);
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe2->id]);

        $response = $this->actingAs($this->user)->get(route('favorites.index', ['difficulty' => 'easy']));

        $response->assertStatus(200);
        $response->assertViewHas('favoriteRecipes', function ($favoriteRecipes) use ($recipe1) {
            return $favoriteRecipes->count() === 1 && $favoriteRecipes->first()->id === $recipe1->id;
        });
    }

    /** @test */
    public function it_sorts_favorites_by_title()
    {
        $category = Category::factory()->create();
        $recipe1 = Recipe::factory()->create(['title' => 'Apple Pie', 'category_id' => $category->id]);
        $recipe2 = Recipe::factory()->create(['title' => 'Zucchini Bread', 'category_id' => $category->id]);
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe1->id]);
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe2->id]);

        $response = $this->actingAs($this->user)->get(route('favorites.index', ['sort' => 'title', 'order' => 'asc']));

        $response->assertStatus(200);
        $response->assertViewHas('favoriteRecipes', function ($favoriteRecipes) use ($recipe1) {
            return $favoriteRecipes->first()->id === $recipe1->id; // Apple Pie comes first
        });
    }


    /** @test */
    public function it_removes_a_favorite()
    {
        $recipe = Recipe::factory()->create();
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe->id]);

        $response = $this->actingAs($this->user)->delete(route('favorites.destroy', $recipe));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Recipe removed from favorites!');
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $this->user->id,
            'recipe_id' => $recipe->id,
        ]);
    }

    /** @test */
    public function it_prevents_removing_nonexistent_favorite()
    {
        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('favorites.destroy', $recipe));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Recipe is not in your favorites.');
    }

    /** @test */
    public function it_removes_a_favorite_via_json()
    {
        $recipe = Recipe::factory()->create();
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe->id]);

        $response = $this->actingAs($this->user)->deleteJson(route('favorites.destroy', $recipe));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Recipe removed from favorites!',
            'is_favorited' => false,
            'favorites_count' => 0,
        ]);
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $this->user->id,
            'recipe_id' => $recipe->id,
        ]);
    }

    /** @test */
    public function it_toggles_favorite_to_add()
    {
        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($this->user)->postJson(route('favorites.toggle', $recipe));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Recipe added to favorites!',
            'is_favorited' => true,
            'favorites_count' => 1,
        ]);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->user->id,
            'recipe_id' => $recipe->id,
        ]);
    }

    /** @test */
    public function it_toggles_favorite_to_remove()
    {
        $recipe = Recipe::factory()->create();
        Favorite::factory()->create(['user_id' => $this->user->id, 'recipe_id' => $recipe->id]);

        $response = $this->actingAs($this->user)->postJson(route('favorites.toggle', $recipe));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Recipe removed from favorites!',
            'is_favorited' => false,
            'favorites_count' => 0,
        ]);
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $this->user->id,
            'recipe_id' => $recipe->id,
        ]);
    }

   
}