<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure;

use Tests\Fixtures\MockMjmlNotification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    /** @test */
    public function itCanHaveADateSet(): void
    {
        $date = now()->addDay();
        $notification = new MockMjmlNotification();

        $notification->forceDate($date);

        $this->assertEquals($date, invade($notification)->date);
    }

    /** @test */
    public function itCanHaveAKeySet(): void
    {
        $key = 'foo';
        $notification = new MockMjmlNotification();

        $notification->setKey($key);

        $this->assertEquals($key, invade($notification)->key);
    }
}
