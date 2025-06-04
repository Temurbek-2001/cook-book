<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $user = new User();
        $fillable = ['name', 'email', 'password'];

        $this->assertEquals($fillable, $user->getFillable());
    }

    /** @test */
    public function it_hides_sensitive_attributes()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
            'remember_token' => 'abc123',
        ]);

        $serialized = $user->toArray();
        $this->assertArrayNotHasKey('password', $serialized);
        $this->assertArrayNotHasKey('remember_token', $serialized);
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'password' => 'password123',
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->email_verified_at);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /** @test */
    public function it_has_many_recipes()
    {
        $user = User::factory()->create();
        $recipes = Recipe::factory()->count(3)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(HasMany::class, $user->recipes());
        $this->assertCount(3, $user->recipes);
        $this->assertTrue($user->recipes->contains($recipes->first()));
    }

    /** @test */
    public function it_has_many_favorites()
    {
        $user = User::factory()->create();
        $favorites = Favorite::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(HasMany::class, $user->favorites());
        $this->assertCount(2, $user->favorites);
        $this->assertTrue($user->favorites->contains($favorites->first()));
    }

    /** @test */
    public function it_belongs_to_many_favorite_recipes()
    {
        $user = User::factory()->create();
        $recipes = Recipe::factory()->count(2)->create();
        $user->favoriteRecipes()->attach($recipes->pluck('id')->toArray(), ['created_at' => now(), 'updated_at' => now()]);

        $this->assertInstanceOf(BelongsToMany::class, $user->favoriteRecipes());
        $this->assertCount(2, $user->favoriteRecipes);
        $this->assertTrue($user->favoriteRecipes->contains($recipes->first()));
        $this->assertNotNull($user->favoriteRecipes()->first()->pivot->created_at);
    }

    /** @test */
    public function it_implements_must_verify_email()
    {
        $user = new User();
        $this->assertInstanceOf(\Illuminate\Contracts\Auth\MustVerifyEmail::class, $user);
    }
}