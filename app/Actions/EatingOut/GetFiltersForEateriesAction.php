<?php

declare(strict_types=1);

namespace App\Actions\EatingOut;

use App\Models\EatingOut\EateryFeature;
use App\Models\EatingOut\EateryType;
use App\Models\EatingOut\EateryVenueType;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GetFiltersForEateriesAction
{
    protected Closure $whereClause;

    protected array $filters;

    public function handle(Closure $whereClause, array $filters = []): array
    {
        $this->filters = $filters;

        $this->whereClause = $whereClause;

        return [
            'categories' => $this->getCategories(),
            'venueTypes' => $this->getVenueTypes(),
            'features' => $this->getFeatures(),
        ];
    }

    /** @return Collection<int, array{value: string, label: string, disabled: bool, checked: bool}> */
    protected function getCategories(): Collection
    {
        return EateryType::query()
            ->withCount(['eateries' => fn (Builder $query) => call_user_func($this->whereClause, $query)])
            ->orderByRaw('eateries_count desc, name asc')
            ->get()
            ->map(fn (EateryType $type): array => [
                'value' => $type->type,
                'label' => "{$type->name} - ({$type->eateries_count})",
                'disabled' => false,
                'checked' => $this->filterIsEnabled('categories', $type->type),
            ]);
    }

    protected function filterIsEnabled(string $key, string $value): bool
    {
        if ( ! Arr::has($this->filters, $key)) {
            return false;
        }

        /** @var string[] $filters */
        $filters = Arr::get($this->filters, $key, []);

        if ( ! $filters) {
            return false;
        }

        return collect($filters)
            ->map(fn (string $filter) => Str::lower($filter))
            ->contains(Str::lower($value));
    }

    /** @return Collection<int, array{value: string, label: string, disabled: bool, checked: bool}> */
    protected function getVenueTypes(): Collection
    {
        return EateryVenueType::query()
            ->withCount(['eateries' => fn (Builder $query) => call_user_func($this->whereClause, $query)])
            ->orderByRaw('eateries_count desc, venue_type asc')
            ->get()
            ->map(fn (EateryVenueType $venueType): array => [
                'value' => $venueType->slug,
                'label' => "{$venueType->venue_type} - ({$venueType->eateries_count})",
                'disabled' => false,
                'checked' => $this->filterIsEnabled('venueTypes', $venueType->slug),
            ]);
    }

    /** @return Collection<int, array{value: string, label: string, disabled: bool, checked: bool}> */
    protected function getFeatures(): Collection
    {
        return EateryFeature::query()
            ->withCount(['eateries' => fn (Builder $query) => call_user_func($this->whereClause, $query)])
            ->orderByRaw('eateries_count desc, feature asc')
            ->get()
            ->map(fn (EateryFeature $feature): array => [
                'value' => $feature->slug,
                'label' => "{$feature->feature} - ({$feature->eateries_count})",
                'disabled' => false,
                'checked' => $this->filterIsEnabled('features', $feature->slug),
            ]);
    }
}