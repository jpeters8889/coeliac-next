<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\Models;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryReview;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

    /** @test */
    public function itHasReviews(): void
    {
        $this->assertEquals(1, $this->eatery->fresh()->reviews()->count());
    }

    /** @test */
    public function itIsNotApprovedByDefault(): void
    {
        $this->assertFalse($this->eatery->fresh()->reviews()->first()->approved);
    }

    /** @test */
    public function itHasAnAverageRating(): void
    {
        $this->eatery->reviews()->delete();

        $this->build(EateryReview::class)
            ->on($this->eatery)
            ->count(2)
            ->state(new Sequence(
                ['rating' => 5],
                ['rating' => 4],
            ))
            ->create();

        $this->assertEquals(4.5, $this->eatery->fresh()->with('reviews')->first()->average_rating);
    }

    /** @test */
    public function itHasAnAverageExpenseAttribute(): void
    {
        $this->eatery->reviews()->delete();

        $this->build(EateryReview::class)
            ->on($this->eatery)
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

    /** @test */
    public function itRoundsTheAveragePriceRatingToTheNearestWholeNumber(): void
    {
        $this->eatery->reviews()->delete();

        $this->build(EateryReview::class)
            ->on($this->eatery)
            ->count(3)
            ->state(new Sequence(
                ['how_expensive' => 4],
                ['how_expensive' => 5],
                ['how_expensive' => 5],
            ))
            ->create();

        $this->assertEquals(5, $this->eatery->fresh()->with('reviews')->first()->average_expense['value']);
    }
}
