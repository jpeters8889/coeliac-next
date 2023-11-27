<?php

declare(strict_types=1);

namespace Tests\Feature\Http\EatingOut\Api;

use App\Models\EatingOut\Eatery;
use App\Pipelines\EatingOut\BrowseEateriesPipeline;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class EatingOutBrowseApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->create(Eatery::class);
    }

    protected function visitRoute(array $params = []): TestResponse
    {
        if ($params === []) {
            $params = array_merge($params, [
                'lat' => 51.5,
                'lng' => -0.1,
                'radius' => 5,
            ]);
        }

        return $this->getJson(route('api.wheretoeat.browse', $params));
    }

    /** @test */
    public function itReturnsAValidationErrorWithAMissingOrInvalidLatField(): void
    {
        $this->visitRoute(['lat' => null])->assertJsonValidationErrorFor('lat');
        $this->visitRoute(['lat' => 'foo'])->assertJsonValidationErrorFor('lat');
    }

    /** @test */
    public function itReturnsAValidationErrorWithAMissingOrInvalidLngField(): void
    {
        $this->visitRoute(['lng' => null])->assertJsonValidationErrorFor('lng');
        $this->visitRoute(['lng' => 'foo'])->assertJsonValidationErrorFor('lng');
    }

    /** @test */
    public function itReturnsAValidationErrorWithAMissingOrInvalidRadiusField(): void
    {
        $this->visitRoute(['radius' => null])->assertJsonValidationErrorFor('radius');
        $this->visitRoute(['radius' => 'foo'])->assertJsonValidationErrorFor('radius');
    }

    /** @test */
    public function itReturnsOk(): void
    {
        $this->visitRoute()->assertOk();
    }

    /** @test */
    public function itCallsTheBrowseEateriesPipeline(): void
    {
        $this->expectPipelineToRun(BrowseEateriesPipeline::class);

        $this->visitRoute();
    }
}
