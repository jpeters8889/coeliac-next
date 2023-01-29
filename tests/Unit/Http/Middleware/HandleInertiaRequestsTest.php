<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\HandleInertiaRequests;
use Closure;
use Illuminate\Support\Collection;
use Tests\TestCase;

class HandleInertiaRequestsTest extends TestCase
{
    protected HandleInertiaRequests $inertiaMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->inertiaMiddleware = resolve(HandleInertiaRequests::class);
    }

    /** @test */
    public function itPassesTheNavigationKeyToTheResponse(): void
    {
        $this->assertArrayHasKey('navigation', $this->inertiaMiddleware->share(request()));
    }

    /** @test */
    public function itPassesTheBlogsWithinTheNavigationObject(): void
    {
        $navigation = $this->inertiaMiddleware->share(request())['navigation'];

        if ($navigation instanceof Closure) {
            $navigation = $navigation();
        }

        $this->assertArrayHasKey('blogs', $navigation);
        $this->assertInstanceOf(Collection::class, $navigation['blogs']);
    }
}
