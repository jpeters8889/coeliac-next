<?php

declare(strict_types=1);

namespace Tests\Unit\Models\EatingOut;

use PHPUnit\Framework\Attributes\Test;
use App\Models\EatingOut\EaterySearchTerm;
use Tests\TestCase;

class EaterySearchTermTest extends TestCase
{
    #[Test]
    public function itGeneratesAKeyWhenARowIsCreated(): void
    {
        $this->assertNotNull($this->create(EaterySearchTerm::class)->key);
    }

    #[Test]
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
