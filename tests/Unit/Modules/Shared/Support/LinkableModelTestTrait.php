<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shared\Support;

use App\Modules\Shared\Support\LinkableModel;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Tests\TestCase;

/** @mixin TestCase */
trait LinkableModelTestTrait
{
    /** @var callable(array $parameters): Model */
    protected $factoryClosure;

    protected string $column;

    /**
     * @param callable(array $parameters): Model $factory
     * @param string $column
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

    /** @test */
    public function itCanGetTheLink(): void
    {
        /** @var LinkableModel $item */
        $item = $this->linkFactory([$this->column => 'foo-bar']);

        $this->assertNotNull($item->link);
        $this->assertStringContainsString('foo-bar', $item->link);
    }

    /** @test */
    public function itCanGetAnAbsoluteLink(): void
    {
        /** @var LinkableModel $item */
        $item = $this->linkFactory([$this->column => 'foo-bar']);

        $this->assertNotNull($item->absolute_link);
        $this->assertStringContainsString(config('app.url'), $item->absolute_link);
        $this->assertStringContainsString('foo-bar', $item->absolute_link);
    }
}
