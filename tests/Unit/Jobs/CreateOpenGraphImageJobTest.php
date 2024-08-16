<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Actions\OpenGraphImages\GenerateCountyOpenGraphImageAction;
use App\Actions\OpenGraphImages\GenerateEateryOpenGraphImageAction;
use App\Actions\OpenGraphImages\GenerateNationwideBranchOpenGraphImageAction;
use App\Actions\OpenGraphImages\GenerateTownOpenGraphImageAction;
use App\Jobs\CreateOpenGraphImageJob;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use App\Models\EatingOut\NationwideBranch;
use App\Models\OpenGraphImage;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use Spatie\Browsershot\Browsershot;
use Tests\TestCase;

class CreateOpenGraphImageJobTest extends TestCase
{
    protected MockInterface $browserShotMock;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->browserShotMock = $this->partialMock(Browsershot::class);

        config()->set('coeliac.generate_og_images', true);
    }

    /**
     * @test
     *
     * @dataProvider openGraphModelsDataProvider
     */
    public function itCallsTheCorrectAction($classString, $expectedAction): void
    {
        $this->browserShotMock->shouldReceive('setHtml')->andThrow(new Exception());

        $model = $this->build($classString)->createQuietly($classString === NationwideBranch::class ? ['wheretoeat_id' => $this->build(Eatery::class)->createQuietly()->id] : []);

        $this->expectAction($expectedAction, return: view('app', ['page' => []]));

        $this->expectException(Exception::class);

        (new CreateOpenGraphImageJob($model))->handle();
    }

    /**
     * @test
     *
     * @dataProvider openGraphModelsDataProvider
     */
    public function itUsesBrowsershot($classString, $action, $useMedia): void
    {
        $this->browserShotMock
            ->shouldReceive('setHtml')->once()->andReturnSelf()->getMock()
            ->shouldReceive('setIncludePath')->with('$PATH')->once()->andReturnSelf()->getMock()
            ->shouldReceive('setNodeBinary')->with(config('browsershot.node_path'))->once()->andReturnSelf()->getMock()
            ->shouldReceive('setNpmBinary')->with(config('browsershot.npm_path'))->once()->andReturnSelf()->getMock()
            ->shouldReceive('windowSize')->with(1200, 630)->andReturnSelf()->once()->getMock()
            ->shouldReceive('base64Screenshot')->andReturn('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAACQkWg2AAAAb0lEQVR4nGK567aCAQZOXAuEs/cf3QZnO3xaDGczMZAIaK+BJVjTFs5RLAyBs1UuS8DZaj8m0tFJJGtgzORshHMELtfA2TMC58LZ7i3MdHQS6fHw6VkPnKMWcRHOlq/JgbOPFO+ko5NI1gAIAAD//3qSF5xOx6hcAAAAAElFTkSuQmCC')->once();

        $model = $this->build($classString)->createQuietly($classString === NationwideBranch::class ? ['wheretoeat_id' => $this->build(Eatery::class)->createQuietly()->id] : []);

        if ($useMedia) {
            $model->addMedia(UploadedFile::fake()->image('image.jpg'))->toMediaCollection('primary');
        }

        (new CreateOpenGraphImageJob($model))->handle();
    }

    /**
     * @test
     *
     * @dataProvider openGraphModelsDataProvider
     */
    public function itCreatesAnOpenGraphRecord($classString, $action, $useMedia): void
    {
        $this->assertDatabaseEmpty(OpenGraphImage::class);
        $this->assertEmpty(Storage::disk('media')->allFiles());

        $this->browserShotMock
            ->shouldReceive('base64Screenshot')
            ->andReturn('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAACQkWg2AAAAb0lEQVR4nGK567aCAQZOXAuEs/cf3QZnO3xaDGczMZAIaK+BJVjTFs5RLAyBs1UuS8DZaj8m0tFJJGtgzORshHMELtfA2TMC58LZ7i3MdHQS6fHw6VkPnKMWcRHOlq/JgbOPFO+ko5NI1gAIAAD//3qSF5xOx6hcAAAAAElFTkSuQmCC')
            ->once();

        $model = $this->build($classString)->createQuietly($classString === NationwideBranch::class ? ['wheretoeat_id' => $this->build(Eatery::class)->createQuietly()->id] : []);

        if ($useMedia) {
            $model->addMedia(UploadedFile::fake()->image('image.jpg'))->toMediaCollection('primary');
        }

        (new CreateOpenGraphImageJob($model))->handle();

        $this->assertDatabaseCount(OpenGraphImage::class, 1);
        $this->assertNotNull($model->refresh()->openGraphImage);

        Storage::disk('media')->assertExists("opengraphimages/{$model->openGraphImage->id}/og-image.png");
    }

    public static function openGraphModelsDataProvider(): array
    {
        return [
            'county' => [EateryCounty::class, GenerateCountyOpenGraphImageAction::class, true],
            'town' => [EateryTown::class, GenerateTownOpenGraphImageAction::class, true],
            'eatery' => [Eatery::class, GenerateEateryOpenGraphImageAction::class, false],
            'nationwide branch' => [NationwideBranch::class, GenerateNationwideBranchOpenGraphImageAction::class, false],
        ];
    }
}
