<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_favorite()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create();
        $favorite = Favorite::create([
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
        ]);

        $this->assertInstanceOf(Favorite::class, $favorite);
        $this->assertEquals($user->id, $favorite->user_id);
        $this->assertEquals($recipe->id, $favorite->recipe_id);
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $favorite = new Favorite();
        $fillable = ['user_id', 'recipe_id'];

        $this->assertEquals($fillable, $favorite->getFillable());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $user = User::factory()->create();
        $favorite = Favorite::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(BelongsTo::class, $favorite->user());
        $this->assertInstanceOf(User::class, $favorite->user);
        $this->assertEquals($user->id, $favorite->user->id);
    }

    /** @test */
    public function it_belongs_to_recipe()
    {
        $recipe = Recipe::factory()->create();
        $favorite = Favorite::factory()->create(['recipe_id' => $recipe->id]);

        $this->assertInstanceOf(BelongsTo::class, $favorite->recipe());
        $this->assertInstanceOf(Recipe::class, $favorite->recipe);
        $this->assertEquals($recipe->id, $favorite->recipe->id);
    }
}