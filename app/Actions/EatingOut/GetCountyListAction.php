<?php

declare(strict_types=1);

namespace App\Actions\EatingOut;

use App\Models\EatingOut\Eatery;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GetCountyListAction
{
    /** @return Collection<string, array{list: Collection<int, object{country: string, county: string, county_slug: string, branches: int, total: int}>, counties: int, count: int}> */
    public function handle(): Collection
    {
        $key = 'wheretoeat_index_county_status';

        if (Cache::has($key)) {
            /** @var Collection<string, array{list: Collection<int, object{country: string, county: string, county_slug: string, branches: int, total: int}>, counties: int, count: int}> $cached */
            $cached = Cache::get($key);

            return $cached;
        }

        /** @var Collection<string, array{list: Collection<int, object{country: string, county: string, county_slug: string, branches: int, total: int}>, counties: int, count: int}> $places */
        $places = $this->getCountries()->map(fn (Collection $places) => [
            'list' => $places->map(fn ($county) => $this->formatCountry($county)),
            'counties' => $places->count(),
            'eateries' => $places->pluck('total')->sum(),
        ]);

        Cache::put($key, $places, now()->addDay());

        return $places;
    }

    /** @param  object{country: string, county: string, county_slug: string, branches: int, total: int}  $details */
    protected function formatCountry(object $details): object
    {
        return (object) [
            'name' => $details->county,
            'slug' => $details->county_slug,
            'total' => $details->branches + $details->total,
        ];
    }

    /** @return Collection<string, Collection<int, object{country: string, county: string, county_slug: string, branches: int, total: int}>> */
    protected function getCountries(): Collection
    {
        /** @var Collection<string, Collection<int, object{country: string, county: string, county_slug: string, branches: int, total: int}>> $countries */
        $countries = Eatery::query()
            ->selectRaw('wheretoeat_countries.country, wheretoeat_counties.county, wheretoeat_counties.slug county_slug')
            ->selectRaw('SUM(1) total')
            ->selectRaw('(select count(*) from wheretoeat_nationwide_branches wnb where wnb.live = 1 and wnb.county_id = wheretoeat_counties.id) branches')
            ->where('wheretoeat.live', true)
            ->where('wheretoeat_counties.county', '!=', 'Nationwide')
            ->leftJoin('wheretoeat_countries', 'country_id', 'wheretoeat_countries.id')
            ->leftJoin('wheretoeat_counties', 'county_id', 'wheretoeat_counties.id')
            ->leftJoin('wheretoeat_types', 'type_id', 'wheretoeat_types.id')
            ->groupBy('wheretoeat_countries.country', 'wheretoeat_counties.county', 'wheretoeat_counties.slug', 'wheretoeat_counties.id')
            ->orderBy('country')
            ->orderBy('county')
            ->get()
            ->groupBy('country');

        return $countries;
    }
}
