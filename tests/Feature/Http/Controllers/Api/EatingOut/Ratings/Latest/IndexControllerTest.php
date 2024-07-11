<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\Ratings\Latest;

use App\Models\EatingOut\EateryReview;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /** @test */
    public function itReturnsTheLatestReviews(): void
    {
        $review = $this->build(EateryReview::class)->approved()->create();

        $this->get(route('api.wheretoeat.ratings.latest'))->assertJsonFragment(['rating' => (string) $review->rating]);
    }

    /** @test */
    public function itReturns5Results(): void
    {
        $this->build(EateryReview::class)->count(10)->approved()->create();

        $this->get(route('api.wheretoeat.ratings.latest'))->assertJsonCount(5);
    }
}
