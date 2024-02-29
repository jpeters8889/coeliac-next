<?php

declare(strict_types=1);

namespace Tests\Unit\Support;

use App\Models\User;
use App\Support\Helpers;
use Money\Money;
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

    /** @test */
    public function itCanFormatMoney(): void
    {
        $amount = Money::GBP(1000);

        $this->assertEquals('£10.00', Helpers::formatMoney($amount));
    }

    /** @test */
    public function itCanReturnTheAdminUser(): void
    {
        $this->withAdminUser();

        $user = User::query()->firstWhere('email', 'contact@coeliacsanctuary.co.uk');

        $this->assertTrue(Helpers::adminUser()->is($user));
    }
}
