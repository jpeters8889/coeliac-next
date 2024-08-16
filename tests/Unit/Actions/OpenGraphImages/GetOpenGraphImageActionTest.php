<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\OpenGraphImages;

use App\Actions\OpenGraphImages\GetOpenGraphImageAction;
use App\Contracts\HasOpenGraphImageContract;
use App\Jobs\CreateOpenGraphImageJob;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use App\Models\EatingOut\NationwideBranch;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetOpenGraphImageActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('coeliac.generate_og_images', true);
    }

    /**
     * @test
     *
     * @dataProvider openGraphModelsDataProvider
     */
    public function itReturnsFromTheModelIfItExists(string $modelClass): void
    {
        Bus::fake();
        Storage::fake('media');

        /** @var HasOpenGraphImageContract $model */
        $model = $this->build($modelClass)->createQuietly();

        $openGraphImage = $model->openGraphImage()->create();

        $openGraphImage->addMedia(UploadedFile::fake()->image('og-image.jpg'))->toMediaCollection();

        app(GetOpenGraphImageAction::class)->handle($model);

        Bus::assertNothingDispatched();
    }

    /**
     * @test
     *
     * @dataProvider openGraphModelsDataProvider
     */
    public function itDispatchesTheJobIfAnOpenGraphImageDoesntExist(string $modelClass): void
    {
        Bus::fake();
        Storage::fake('media');

        /** @var HasOpenGraphImageContract $model */
        $model = $this->build($modelClass)->createQuietly();

        $this->assertNull($model->openGraphImage);

        app(GetOpenGraphImageAction::class)->handle($model);

        Bus::assertDispatched(CreateOpenGraphImageJob::class);
    }

    public static function openGraphModelsDataProvider(): array
    {
        return [
            'county' => [EateryCounty::class],
            'town' => [EateryTown::class],
            'eatery' => [Eatery::class],
            'nationwide branch' => [NationwideBranch::class],
        ];
    }
}
