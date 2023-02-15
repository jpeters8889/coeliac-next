<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shared;

use App\Modules\Blog\Models\Blog;
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
    public function itHasTheTwoLatestBlogs(): void
    {
        $this->withBlogs(3)
            ->get(route('home'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Home')
                    ->has(
                        'blogs',
                        2,
                        fn (Assert $page) => $page
                            ->hasAll(['title', 'description', 'date', 'image', 'link'])
                    )
                    ->where('blogs.0.title', 'Blog 0')
                    ->where('blogs.1.title', 'Blog 1')
                    ->etc()
            );
    }

    /** @test */
    public function itDoesntReturnBlogsThatArentLive(): void
    {
        $this->withBlogs(3, fn () => Blog::query()->first()->update(['live' => false]))
            ->get(route('home'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Home')
                    ->has(
                        'blogs',
                        2,
                        fn (Assert $page) => $page
                            ->hasAll(['title', 'description', 'date', 'image', 'link'])
                    )
                    ->where('blogs.0.title', 'Blog 1')
                    ->where('blogs.1.title', 'Blog 2')
                    ->etc()
            );
    }
}
