<?php

declare(strict_types=1);

namespace Tests\Unit\Support;

use App\Support\Helpers;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    public function itCanConvertMilesToMeters(): void
    {
        $miles = 5;
        $ratio = 1609.344;

        $this->assertEquals(round($miles * $ratio), Helpers::milesToMeters($miles));
    }
}
