<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Actions\Shop\GetStripeChargeAction;
use Stripe\Charge;
use Tests\Concerns\MocksStripe;
use Tests\TestCase;

class GetStripeChargeActionTest extends TestCase
{
    use MocksStripe;

    #[Test]
    public function itCanGetACharge(): void
    {
        $this->mockRetrieveCharge('foo');

        $result = $this->callAction(GetStripeChargeAction::class, 'foo');

        $this->assertInstanceOf(Charge::class, $result);
    }
}
