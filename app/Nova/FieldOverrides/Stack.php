<?php

declare(strict_types=1);

namespace App\Nova\FieldOverrides;

use Closure;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * @codeCoverageIgnore
 *
 * @method static static make(string $name, Closure $lines)
 */
class Stack extends \Laravel\Nova\Fields\Stack
{
    protected ?Closure $loadClasses = null;

    protected ?Closure $unpreparedLines = null;

    public function __construct($name, Closure $lines)
    {
        parent::__construct($name);

        $this->unpreparedLines = $lines;
    }

    public function prepareLines($resource, $attribute = null): void
    {
        $this->processLines($resource);

        $request = app(NovaRequest::class);

        $this->lines = $this->lines->filter(function (Line $field) use ($request, $resource) {
            if ($request->isResourceIndexRequest()) {
                return $field->isShownOnIndex($request, $resource);
            }

            return $field->isShownOnDetail($request, $resource);
        })->values()->each->resolveForDisplay($resource, $attribute);
    }

    protected function processLines(mixed $resource): void
    {
        $this->lines = collect(call_user_func($this->unpreparedLines, $resource))
            ->when(fn (Collection $items) => $items->count() > 1, fn (Collection $items) => $items->map(fn (array $lines, $index) => [
                $lines[0],
                $lines[1],
                $lines[2]->extraClasses($index < $items->count() - 1 ? 'inline-block border-b border-gray-300 pb-2 mb-2' : ''),
            ]))
            ->flatten();
    }

    public function withClasses(Closure $callable): self
    {
        $this->loadClasses = $callable;

        return $this;
    }
}
