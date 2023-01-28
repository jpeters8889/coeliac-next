<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shared\Support;

use App\Modules\Blog\Models\Blog;
use Closure;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Tests\TestCase;

class DisplaysMediaTest extends TestCase
{
    protected array $models = [];

    protected const SOCIAL_IMAGE = 'social.jpg';

    protected const PRIMARY_IMAGE = 'primary.jpg';

    protected const FIRST_IMAGE = 'article1.jpg';

    protected const BODY_IMAGE = 'article2.jpg';

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $blog = $this->create(Blog::class);

        $blog->addMedia(UploadedFile::fake()->image(self::SOCIAL_IMAGE))->toMediaCollection('social');
        $blog->addMedia(UploadedFile::fake()->image(self::PRIMARY_IMAGE))->toMediaCollection('primary');
        $blog->addMedia(UploadedFile::fake()->image(self::FIRST_IMAGE))->toMediaCollection();
        $blog->addMedia(UploadedFile::fake()->image(self::BODY_IMAGE))->toMediaCollection();

        $this->models[] = $blog;
    }

    /** @param $test Closure(HasMedia $model) */
    protected function runTests(Closure $test): void
    {
        collect($this->models)->each(function (HasMedia $model) use ($test): void {
            $test($model);
        });
    }

    /** @test */
    public function itCanGetTheFirstImage(): void
    {
        $this->runTests(function (HasMedia $model): void {
            $firstImage = $model->first_image;

            $this->assertNotNull($firstImage);
            $this->assertStringContainsString(self::FIRST_IMAGE, $firstImage);
        });
    }

    /** @test */
    public function itCanGetThePrimaryImage(): void
    {
        $this->runTests(function (HasMedia $model): void {
            $primaryImage = $model->main_image;

            $this->assertNotNull($primaryImage);
            $this->assertStringContainsString(self::PRIMARY_IMAGE, $primaryImage);
        });
    }

    /** @test */
    public function itCanGetTheSocialImage(): void
    {
        $this->runTests(function (HasMedia $model): void {
            $socialImage = $model->social_image;

            $this->assertNotNull($socialImage);
            $this->assertStringContainsString(self::SOCIAL_IMAGE, $socialImage);
        });
    }
}
