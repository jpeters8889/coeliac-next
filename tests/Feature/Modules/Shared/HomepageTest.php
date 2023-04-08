<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shared;

use App\Modules\Blog\Models\Blog;
use App\Modules\Recipe\Models\Recipe;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    /** @test */
    public function itLoadsTheHomepage(): void
    {
        $this->get(route('home'))->assertOk();
    }

    /** @test */
    public function itHasTheSixLatestBlogs(): void
    {
        $this->withBlogs()
            ->get(route('home'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Home')
                    ->has(
                        'blogs',
                        6,
                        fn (Assert $page) => $page
                            ->hasAll(['title', 'image', 'link'])
                    )
                    ->where('blogs.0.title', 'Blog 0')
                    ->where('blogs.1.title', 'Blog 1')
                    ->etc()
            );
    }

    /** @test */
    public function itDoesntReturnBlogsThatArentLive(): void
    {
        $this->withBlogs(then: fn () => Blog::query()->first()->update(['live' => false]))
            ->get(route('home'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Home')
                    ->has(
                        'blogs',
                        6,
                        fn (Assert $page) => $page
                            ->hasAll(['title', 'image', 'link'])
                    )
                    ->where('blogs.0.title', 'Blog 1')
                    ->where('blogs.1.title', 'Blog 2')
                    ->etc()
            );
    }

    /** @test */
    public function itHasTheEightLatestRecipes(): void
    {
        $this->withRecipes()
            ->get(route('home'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Home')
                    ->has(
                        'recipes',
                        8,
                        fn (Assert $page) => $page
                            ->hasAll(['title', 'image', 'link'])
                    )
                    ->where('recipes.0.title', 'Recipe 0')
                    ->where('recipes.1.title', 'Recipe 1')
                    ->etc()
            );
    }

    /** @test */
    public function itDoesntReturnRecipesThatArentLive(): void
    {
        $this->withRecipes(then: fn () => Recipe::query()->first()->update(['live' => false]))
            ->get(route('home'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Home')
                    ->has(
                        'recipes',
                        8,
                        fn (Assert $page) => $page
                            ->hasAll(['title', 'image', 'link'])
                    )
                    ->where('recipes.0.title', 'Recipe 1')
                    ->where('recipes.1.title', 'Recipe 2')
                    ->etc()
            );
    }
}
