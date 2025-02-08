<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut;

use App\Actions\EatingOut\GetEateryStatisticsAction;
use App\DataObjects\EatingOut\EateryStatistics;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryReview;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetEateryStatisticsActionTest extends TestCase
{
    #[Test]
    public function itCachesTheResult(): void
    {
        Cache::shouldReceive('rememberForever')
            ->once()
            ->andReturn(new EateryStatistics(1, 2, 3, 4, 5));

        app(GetEateryStatisticsAction::class)->handle();
    }

    #[Test]
    public function itDoesntCountNonLiveEateries(): void
    {
        $this->build(Eatery::class)->notLive()->create();

        $statistics = app(GetEateryStatisticsAction::class)->handle();

        $this->assertEquals(0, $statistics->total);
    }

    #[Test]
    public function itReturnsTheCountOfEateries(): void
    {
        $this->build(Eatery::class)
            ->count(20)
            ->create();

        $statistics = app(GetEateryStatisticsAction::class)->handle();

        $this->assertEquals(20, $statistics->eateries);
    }

    #[Test]
    public function itReturnsTheCountOfAttractions(): void
    {
        $this->build(Eatery::class)
            ->attraction()
            ->count(15)
            ->create();

        $statistics = app(GetEateryStatisticsAction::class)->handle();

        $this->assertEquals(15, $statistics->attractions);
    }

    #[Test]
    public function itReturnsTheCountOfHotels(): void
    {
        $this->build(Eatery::class)
            ->hotel()
            ->count(10)
            ->create();

        $statistics = app(GetEateryStatisticsAction::class)->handle();

        $this->assertEquals(10, $statistics->hotels);
    }

    #[Test]
    public function itReturnsATotalOfAllEateriesAttractionsAndHotels(): void
    {
        $this->build(Eatery::class)
            ->count(20)
            ->create();

        $this->build(Eatery::class)
            ->attraction()
            ->count(15)
            ->create();

        $this->build(Eatery::class)
            ->hotel()
            ->count(10)
            ->create();

        $statistics = app(GetEateryStatisticsAction::class)->handle();

        $this->assertEquals(45, $statistics->total);
    }

    #[Test]
    public function itReturnsTheCountOfReviews(): void
    {
        $this->build(Eatery::class)
            ->count(20)
            ->has($this->build(EateryReview::class)->count(5)->approved(), 'reviews')
            ->create();

        $statistics = app(GetEateryStatisticsAction::class)->handle();

        $this->assertEquals(100, $statistics->reviews);
    }
}
