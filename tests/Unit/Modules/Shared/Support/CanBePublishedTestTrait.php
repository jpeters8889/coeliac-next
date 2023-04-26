<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shared\Support;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

/** @mixin TestCase */
trait CanBePublishedTestTrait
{
    /** @var callable(array $parameters): Model */
    protected $factoryClosure;

    /**
     * @param callable(array $parameters): Model $factory
     * @param string $column
     */
    protected function setUpCanBePublishedModelTest(callable $factory): void
    {
        $this->factoryClosure = $factory;
    }

    private function factory($params = []): Model
    {
        return call_user_func($this->factoryClosure, $params);
    }

    /** @test */
    public function itHasAPublishAtColumn(): void
    {
        $this->assertNotNull($this->factory()->publish_at);
    }

    /** @test */
    public function itCastsThePublishAtColumnToCarbon(): void
    {
        $this->assertInstanceOf(Carbon::class, $this->factory()->publish_at);
    }

    /** @test */
    public function itHasADraftColumn(): void
    {
        $this->assertNotNull($this->factory()->draft);
    }

    /** @test */
    public function itCastsTheDraftColumnAsABool(): void
    {
        $this->assertIsBool($this->factory()->draft);
    }
}
