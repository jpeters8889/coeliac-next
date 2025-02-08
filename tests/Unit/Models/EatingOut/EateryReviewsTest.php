<?php

declare(strict_types=1);

namespace Tests\Unit\Models\EatingOut;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryReview;
use App\Models\EatingOut\EateryTown;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EateryReviewsTest extends TestCase
{
    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eatery = $this->create(Eatery::class);

        $this->build(EateryReview::class)
            ->on($this->eatery)
            ->create();
    }

    #[Test]
    public function itHasReviews(): void
    {
        $this->assertEquals(1, $this->eatery->fresh()->reviews()->withoutGlobalScopes()->count());
    }

    #[Test]
    public function itIsNotApprovedByDefault(): void
    {
        $this->assertFalse($this->eatery->fresh()->reviews()->withoutGlobalScopes()->first()->approved);
    }

    #[Test]
    public function itHasAnAverageRating(): void
    {
        $this->eatery->reviews()->delete();

        $this->build(EateryReview::class)
            ->on($this->eatery)
            ->approved()
            ->count(2)
            ->state(new Sequence(
                ['rating' => 5],
                ['rating' => 4],
            ))
            ->create();

        $this->assertEquals(4.5, $this->eatery->fresh()->with('reviews')->first()->average_rating);
    }

    #[Test]
    public function itHasAnAverageExpenseAttribute(): void
    {
        $this->eatery->reviews()->delete();

        $this->build(EateryReview::class)
            ->on($this->eatery)
            ->approved()
            ->count(2)
            ->state(new Sequence(
                ['how_expensive' => 1],
                ['how_expensive' => 5],
            ))
            ->create();

        $averageExpense = $this->eatery->fresh()->with('reviews')->first()->average_expense;

        $this->assertIsArray($averageExpense);
        $this->assertArrayHasKey('value', $averageExpense);
        $this->assertArrayHasKey('label', $averageExpense);
        $this->assertEquals(3, $averageExpense['value']);
    }

    #[Test]
    public function itRoundsTheAveragePriceRatingToTheNearestWholeNumber(): void
    {
        $this->eatery->reviews()->delete();

        $this->build(EateryReview::class)
            ->on($this->eatery)
            ->approved()
            ->count(3)
            ->state(new Sequence(
                ['how_expensive' => 4],
                ['how_expensive' => 5],
                ['how_expensive' => 5],
            ))
            ->create();

        $this->assertEquals(5, $this->eatery->fresh()->with('reviews')->first()->average_expense['value']);
    }

    #[Test]
    public function itClearsCacheWhenARowIsCreated(): void
    {
        $eatery = $this->create(Eatery::class);

        foreach (config('coeliac.cacheable.eating-out-reviews') as $key) {
            if (str_contains($key, '{')) {
                continue;
            }

            Cache::put($key, 'foo');

            $this->build(EateryReview::class)->on($eatery)->create();

            $this->assertFalse(Cache::has($key));
        }
    }

    #[Test]
    public function itClearsCacheWhenARowIsUpdated(): void
    {
        $eatery = $this->create(Eatery::class);

        foreach (config('coeliac.cacheable.eating-out-reviews') as $key) {
            if (str_contains($key, '{')) {
                continue;
            }

            $review = $this->build(EateryReview::class)->on($eatery)->create();

            Cache::put($key, 'foo');

            $review->update();

            $this->assertFalse(Cache::has($key));
        }
    }

    #[Test]
    public function itCanClearWildCardCacheEntriesWhenARecordIsCreated(): void
    {
        $county = $this->create(EateryCounty::class);
        $town = $this->create(EateryTown::class, [
            'county_id' => $county->id,
        ]);

        $eatery = $this->create(Eatery::class, [
            'county_id' => $county->id,
            'town_id' => $town->id,
        ]);

        foreach (config('coeliac.cacheable.eating-out-reviews') as $key) {
            if ( ! str_contains($key, '{')) {
                continue;
            }

            $key = str_replace('{eatery.county.slug}', $county->slug, $key);

            Cache::put($key, 'foo');

            $this->build(EateryReview::class)->on($eatery)->create();

            $this->assertFalse(Cache::has($key));
        }
    }

    #[Test]
    public function itCanClearWildCardCacheEntriesWhenARecordIsUpdated(): void
    {
        $county = $this->create(EateryCounty::class);
        $town = $this->create(EateryTown::class, [
            'county_id' => $county->id,
        ]);

        $eatery = $this->create(Eatery::class, [
            'county_id' => $county->id,
            'town_id' => $town->id,
        ]);

        foreach (config('coeliac.cacheable.eating-out-reviews') as $key) {
            if ( ! str_contains($key, '{')) {
                continue;
            }

            $review = $this->build(EateryReview::class)->on($eatery)->create();

            $key = str_replace('{eatery.county.slug}', $county->slug, $key);

            Cache::put($key, 'foo');

            $review->update();

            $this->assertFalse(Cache::has($key));
        }
    }
}
