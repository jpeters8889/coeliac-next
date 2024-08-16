<?php

declare(strict_types=1);

namespace Tests\Unit\Models\EatingOut;

use App\Jobs\CreateOpenGraphImageJob;
use App\Models\EatingOut\EateryCounty;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class EateryCountyTest extends TestCase
{
    /** @test */
    public function itDispatchesTheCreateOpenGraphImageJobWhenSaved(): void
    {
        Bus::fake();

        $this->create(EateryCounty::class);

        Bus::assertDispatched(CreateOpenGraphImageJob::class);
    }
}
