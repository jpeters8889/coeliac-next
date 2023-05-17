<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\Models;

use App\Modules\EatingOut\Models\EaterySearchTerm;
use Tests\TestCase;

class EaterySearchTermTest extends TestCase
{
    /** @test */
    public function itGeneratesAKeyWhenARowIsCreated(): void
    {
        $this->assertNotNull($this->create(EaterySearchTerm::class)->key);
    }

    /** @test */
    public function itCanHaveSearchesAppliedToIt(): void
    {
        /** @var EaterySearchTerm $searchTerm */
        $searchTerm = $this->create(EaterySearchTerm::class);

        $this->assertEmpty($searchTerm->searches);

        $searchTerm->logSearch();

        $this->assertNotEmpty($searchTerm->fresh()->searches);
        $this->assertCount(1, $searchTerm->fresh()->searches);

        $searchTerm->logSearch();

        $this->assertCount(2, $searchTerm->fresh()->searches);
    }
}
