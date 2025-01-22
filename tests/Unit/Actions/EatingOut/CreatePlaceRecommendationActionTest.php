<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut;

use PHPUnit\Framework\Attributes\Test;
use App\Actions\EatingOut\CreatePlaceRecommendationAction;
use App\Models\EatingOut\EateryRecommendation;
use Tests\RequestFactories\EateryRecommendAPlaceRequestFactory;
use Tests\TestCase;

class CreatePlaceRecommendationActionTest extends TestCase
{
    #[Test]
    public function itCreatesThePlaceRecommendation(): void
    {
        $data = EateryRecommendAPlaceRequestFactory::new()->create();

        $this->assertDatabaseEmpty(EateryRecommendation::class);

        $this->callAction(CreatePlaceRecommendationAction::class, $data);

        $this->assertDatabaseCount(EateryRecommendation::class, 1);
    }
}
