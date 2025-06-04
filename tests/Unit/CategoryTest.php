<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_category()
    {
        $category = Category::create([
            'name' => 'Desserts',
            'description' => 'Sweet treats and baked goods'
        ]);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals('Desserts', $category->name);
        $this->assertEquals('Sweet treats and baked goods', $category->description);
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $category = new Category();
        $fillable = ['name', 'description'];

        $this->assertEquals($fillable, $category->getFillable());
    }

    /** @test */
    public function it_has_many_recipes()
    {
        $category = Category::factory()->create();
        $recipes = Recipe::factory()->count(3)->create(['category_id' => $category->id]);

        $this->assertInstanceOf(HasMany::class, $category->recipes());
        $this->assertCount(3, $category->recipes);
        $this->assertTrue($category->recipes->contains($recipes->first()));
    }

    /** @test */
    public function it_returns_correct_recipes_count()
    {
        $category = Category::factory()->create();
        Recipe::factory()->count(5)->create(['category_id' => $category->id]);

        $this->assertEquals(5, $category->recipes_count);
    }

    /** @test */
    public function it_returns_zero_recipes_count_when_no_recipes()
    {
        $category = Category::factory()->create();

        $this->assertEquals(0, $category->recipes_count);
    }
}