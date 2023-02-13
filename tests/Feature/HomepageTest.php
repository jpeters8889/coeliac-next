<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Modules\Blog\Models\Blog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        Storage::fake('media');

        $this->build(Blog::class)
            ->count(3)
            ->sequence(fn(Sequence $sequence) => [
                'title' => "Blog {$sequence->index}",
                'created_at' => Carbon::now()->subDays($sequence->index)
            ])
            ->create()
            ->each(function (Blog $blog): void {
                $blog->addMedia(UploadedFile::fake()->image('blog.jpg'))->toMediaCollection('primary');
            });

        $this->get(route('home'))
            ->assertInertia(fn (Assert $page) => $page
            ->component('Home')
            ->has('blogs', 2, fn(Assert $page) => $page
                ->hasAll(['title', 'description', 'date', 'image', 'link'])
            )
            ->where('blogs.0.title', 'Blog 0')
            ->where('blogs.1.title', 'Blog 1')
            ->etc()
        );
    }
}
