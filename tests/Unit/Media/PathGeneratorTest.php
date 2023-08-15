<?php

declare(strict_types=1);

namespace Tests\Unit\Media;

use App\Media\PathGenerator;
use App\Models\Blogs\Blog;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PathGeneratorTest extends TestCase
{
    protected Blog $blog;

    protected string $path;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $pathGenerator = new PathGenerator();

        $this->blog = $this->create(Blog::class);
        $this->blog->addMedia(UploadedFile::fake()->image('foo.jpg'))->toMediaCollection();

        $media = Media::query()->first();

        $this->path = $pathGenerator->getPath($media);
    }

    /** @test */
    public function itCanLoadTheCustomPathWithATheModelBasename(): void
    {
        $this->assertStringContainsString('blogs', $this->path);
    }

    /** @test */
    public function itCanLoadTheCustomPathWithASlug(): void
    {
        $this->assertStringContainsString($this->blog->slug, $this->path);
    }
}
