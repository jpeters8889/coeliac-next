<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\NotificationEmail;
use App\Models\Shop\ShopCustomer;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;

class NotificationEmailTest extends TestCase
{
    /** @test */
    public function itCreatesAUuidForTheKeyIfNotSpecified(): void
    {
        $model = $this->create(NotificationEmail::class);

        $this->assertNotNull($model->key);
        $this->assertTrue(Str::isUuid($model->key));
    }

    /** @test */
    public function itCastsTheEmailData(): void
    {
        /** @var NotificationEmail $model */
        $model = $this->create(NotificationEmail::class);

        $this->assertIsArray($model->data);
        $this->assertArrayHasKey('date', $model->data);
        $this->assertInstanceOf(Carbon::class, $model->data['date']);
    }

    /** @test */
    public function itCanBeAssociatedToAShopCustomer(): void
    {
        /** @var NotificationEmail $model */
        $model = $this->create(NotificationEmail::class);

        $this->assertInstanceOf(ShopCustomer::class, $model->customer);
    }
}
