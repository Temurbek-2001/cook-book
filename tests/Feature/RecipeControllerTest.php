<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_displays_the_recipes_index_page()
    {
        $category = Category::factory()->create();
        Recipe::factory()->count(3)->create(['category_id' => $category->id, 'user_id' => $this->user->id]);

        $response = $this->get(route('recipes.index'));

        $response->assertStatus(200);
        $response->assertViewIs('recipes.index');
        $response->assertViewHas('recipes', function ($recipes) {
            return $recipes->count() === 3;
        });
    }

    /** @test */
    public function it_displays_the_create_recipe_page_for_authenticated_user()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->user)->get(route('recipes.create'));

        $response->assertStatus(200);
        $response->assertViewIs('recipes.create');
        $response->assertViewHas('categories', function ($categories) use ($category) {
            return $categories->contains($category);
        });
    }

    /** @test */
    public function it_redirects_unauthenticated_user_from_create_page()
    {
        $response = $this->get(route('recipes.create'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_stores_a_new_recipe()
    {
        Storage::fake('public');
        $category = Category::factory()->create();
        $image = UploadedFile::fake()->image('recipe.jpg');

        $response = $this->actingAs($this->user)->post(route('recipes.store'), [
            'title' => 'Chocolate Cake',
            'description' => 'Delicious chocolate cake',
            'ingredients' => ['flour', 'sugar', 'cocoa'],
            'instructions' => 'Mix and bake',
            'preparation_time' => 30,
            'cooking_time' => 45,
            'difficulty_level' => 'medium',
            'image_path' => $image,
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('recipes.index'));
        $response->assertSessionHas('success', 'Recipe created successfully.');
        $this->assertDatabaseHas('recipes', [
            'title' => 'Chocolate Cake',
            'user_id' => $this->user->id,
            'category_id' => $category->id,
        ]);
        Storage::disk('public')->assertExists('recipes/' . $image->hashName());
    }

    /** @test */
    public function it_fails_to_store_recipe_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->post(route('recipes.store'), [
            'title' => '',
            'ingredients' => [],
            'preparation_time' => 0,
        ]);

        $response->assertSessionHasErrors(['title', 'ingredients', 'preparation_time']);
    }

}