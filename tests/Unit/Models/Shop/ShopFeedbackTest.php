<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopFeedback;
use App\Models\Shop\ShopProduct;
use Tests\TestCase;

class ShopFeedbackTest extends TestCase
{
    #[Test]
    public function itHasAProductRelationship(): void
    {
        $product = $this->create(ShopProduct::class);

        $feedback = $this->build(ShopFeedback::class)
            ->forProduct($product)
            ->create();

        $this->assertInstanceOf(ShopProduct::class, $feedback->product()->withoutGlobalScopes()->first());
        $this->assertTrue($feedback->product()->withoutGlobalScopes()->first()->is($product));
    }
}
