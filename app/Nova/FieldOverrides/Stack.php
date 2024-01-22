<?php

declare(strict_types=1);

namespace App\Nova\FieldOverrides;

use Closure;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Http\Requests\NovaRequest;

class Stack extends \Laravel\Nova\Fields\Stack
{
    protected ?Closure $loadClasses = null;

    public function prepareLines($resource, $attribute = null): void
    {
        $this->processLines($resource);

        $request = app(NovaRequest::class);

        if ( ! $this->lines instanceof Collection) {
            $this->lines = collect($this->lines);
        }

        $this->lines = $this->lines->filter(function (Line $field) use ($request, $resource) {
            if ($request->isResourceIndexRequest()) {
                return $field->isShownOnIndex($request, $resource);
            }

            return $field->isShownOnDetail($request, $resource);
        })->values()->each->resolveForDisplay($resource, $attribute);
    }

    protected function processLines(mixed $resource): void
    {
        $this->lines = collect($this->lines)->map(function ($line) use ($resource) {
            if (is_callable($line)) {
                $lines = $line($resource);

                if ($lines instanceof Collection) {
                    return $lines->map(fn ($l) => Line::make('Anonymous', fn () => $l)
                        ->extraClasses($this->loadClasses ? call_user_func($this->loadClasses, $l) : ''));
                }

                return Line::make('Anonymous', $line)
                    ->extraClasses($this->loadClasses ? call_user_func($this->loadClasses, $line) : '');
            }

            return $line;
        })->flatten();
    }

    public function withClasses(Closure $callable): self
    {
        $this->loadClasses = $callable;

        return $this;
    }
}
