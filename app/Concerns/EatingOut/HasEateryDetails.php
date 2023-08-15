<?php

declare(strict_types=1);

namespace App\Concerns\EatingOut;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCountry;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

/**
 * @mixin Model
 *
 * @property string $name
 * @property EateryTown $town
 * @property EateryCounty $county
 * @property EateryCountry $country
 * @property string $address
 * @property int $lat
 * @property int $lng
 * @property bool $live
 * @property int $id
 * @property string $full_location
 * @property null|string $slug
 * @property number $town_id
 */
trait HasEateryDetails
{
    protected function hasDuplicateNameInTown(): bool
    {
        return self::query()
            ->where('town_id', $this->town_id)
            ->where('name', $this->name)
            ->where('live', 1)
            ->count() > 1;
    }

    protected function eateryPostcode(): string
    {
        $address = explode('<br />', $this->address);

        return array_pop($address);
    }

    public function generateSlug(): string
    {
        if ($this->slug) {
            return $this->slug;
        }

        return Str::of($this->name ?: $this->town->town)
            ->when(
                $this->hasDuplicateNameInTown(),
                fn (Stringable $str) => $str->append(' ' . $this->eateryPostcode()),
            )
            ->slug()
            ->toString();
    }

    /** @return BelongsTo<Eatery, self> */
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class, 'wheretoeat_id', 'id');
    }

    /** @return BelongsTo<EateryTown, self> */
    public function town(): BelongsTo
    {
        return $this->belongsTo(EateryTown::class, 'town_id');
    }

    /** @return BelongsTo<EateryCounty, self> */
    public function county(): BelongsTo
    {
        return $this->belongsTo(EateryCounty::class, 'county_id');
    }

    /** @return BelongsTo<EateryCountry, self> */
    public function country(): BelongsTo
    {
        return $this->belongsTo(EateryCountry::class, 'country_id');
    }

    /** @return Attribute<string, never> */
    public function formattedAddress(): Attribute
    {
        return Attribute::get(fn () => Str::of($this->address)->explode('<br />')->join(', '));
    }

    /** @return Attribute<string | null, never> */
    public function fullLocation(): Attribute
    {
        return Attribute::get(function () {
            if ( ! $this->relationLoaded('town')) {
                return null;
            }

            if (Str::lower($this->town->town) === 'nationwide') {
                return "{$this->name}, Nationwide";
            }

            return implode(', ', [
                $this->town->town,
                $this->county->county,
                $this->country->country,
            ]);
        });
    }
}
