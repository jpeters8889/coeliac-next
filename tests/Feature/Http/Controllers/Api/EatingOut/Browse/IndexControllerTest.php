<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\Browse;

use PHPUnit\Framework\Attributes\Test;
use App\Models\EatingOut\Eatery;
use App\Pipelines\EatingOut\GetEateries\BrowseEateriesPipeline;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class IndexControllerTest extends TestCase
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

    #[Test]
    public function itReturnsAValidationErrorWithAMissingOrInvalidLatField(): void
    {
        $this->visitRoute(['lat' => null])->assertJsonValidationErrorFor('lat');
        $this->visitRoute(['lat' => 'foo'])->assertJsonValidationErrorFor('lat');
    }

    #[Test]
    public function itReturnsAValidationErrorWithAMissingOrInvalidLngField(): void
    {
        $this->visitRoute(['lng' => null])->assertJsonValidationErrorFor('lng');
        $this->visitRoute(['lng' => 'foo'])->assertJsonValidationErrorFor('lng');
    }

    #[Test]
    public function itReturnsAValidationErrorWithAMissingOrInvalidRadiusField(): void
    {
        $this->visitRoute(['radius' => null])->assertJsonValidationErrorFor('radius');
        $this->visitRoute(['radius' => 'foo'])->assertJsonValidationErrorFor('radius');
    }

    #[Test]
    public function itReturnsOk(): void
    {
        $this->visitRoute()->assertOk();
    }

    #[Test]
    public function itCallsTheBrowseEateriesPipeline(): void
    {
        $this->expectPipelineToRun(BrowseEateriesPipeline::class);

        $this->visitRoute();
    }
}
