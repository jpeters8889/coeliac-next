<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\VenueTypes;

use PHPUnit\Framework\Attributes\Test;
use App\Models\EatingOut\EateryVenueType;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    #[Test]
    public function itReturnsTheVenueTypes(): void
    {
        $this->build(EateryVenueType::class)->count(5)->create();

        $this->get(route('api.wheretoeat.venueTypes'))->assertJsonCount(5);
    }
}
