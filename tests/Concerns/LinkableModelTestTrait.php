<?php

declare(strict_types=1);

namespace Tests\Concerns;

use PHPUnit\Framework\Attributes\Test;
use App\Concerns\LinkableModel;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

/** @mixin TestCase */
trait LinkableModelTestTrait
{
    /** @var callable(array): Model */
    protected $factoryClosure;

    protected string $column;

    /**
     * @param  callable(array $parameters): Model  $factory
     */
    protected function setUpLinkableModelTest(callable $factory, string $column = 'slug'): void
    {
        $this->factoryClosure = $factory;
        $this->column = $column;
    }

    private function linkFactory($params = []): Model
    {
        return call_user_func($this->factoryClosure, $params);
    }

    #[Test]
    public function itCanGetTheLink(): void
    {
        /** @var LinkableModel $item */
        $item = $this->linkFactory([$this->column => 'foo-bar']);

        $this->assertNotNull($item->link);
        $this->assertStringContainsString('foo-bar', $item->link);
    }

    #[Test]
    public function itCanGetAnAbsoluteLink(): void
    {
        /** @var LinkableModel $item */
        $item = $this->linkFactory([$this->column => 'foo-bar']);

        $this->assertNotNull($item->absolute_link);
        $this->assertStringContainsString(config('app.url'), $item->absolute_link);
        $this->assertStringContainsString('foo-bar', $item->absolute_link);
    }
}
