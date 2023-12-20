<?php

declare(strict_types=1);

namespace App\Models\Shop;

use App\Concerns\DisplaysMedia;
use App\Concerns\LinkableModel;
use App\Legacy\HasLegacyImage;
use App\Legacy\Imageable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $currentPrice
 * @property null | int $oldPrice
 */
class ShopProduct extends Model implements HasMedia
{
    use DisplaysMedia;
    use HasLegacyImage;
    use Imageable;
    use InteractsWithMedia;
    use LinkableModel;
    use Searchable;

    protected static function booted(): void
    {
        static::addGlobalScope(fn (Builder $builder) => $builder->whereHas('variants'));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('social')->singleFile();

        $this->addMediaCollection('primary')->singleFile();
    }

    /** @return BelongsToMany<ShopCategory> */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ShopCategory::class, 'shop_product_categories', 'product_id', 'category_id');
    }

    /** @return BelongsTo<ShopShippingMethod, self> */
    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShopShippingMethod::class);
    }

    /** @return HasMany<ShopProductVariant> */
    public function variants(): HasMany
    {
        return $this->hasMany(ShopProductVariant::class, 'product_id');
    }

    /** @return HasMany<ShopProductPrice> */
    public function prices(): HasMany
    {
        return $this->hasMany(ShopProductPrice::class, 'product_id');
    }

    /** @return HasMany<ShopFeedback> */
    public function feedback(): HasMany
    {
        return $this->hasMany(ShopFeedback::class, 'product_id');
    }

    /** @return HasMany<ShopOrderReviewItem> */
    public function reviews(): HasMany
    {
        return $this->hasMany(ShopOrderReviewItem::class, 'product_id');
    }

    /** @return BelongsToMany<TravelCardSearchTerm> */
    public function travelCardSearchTerms(): BelongsToMany
    {
        return $this->belongsToMany(
            TravelCardSearchTerm::class,
            'shop_product_assigned_travel_card_search_terms',
            'product_id',
            'search_term_id',
        );
    }

    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    /** @return Collection<int, ShopProductPrice> */
    public function currentPrices(): Collection
    {
        return $this->prices
            ->filter(fn (ShopProductPrice $price) => $price->start_at->lessThan(Carbon::now()))
            ->filter(fn (ShopProductPrice $price) => ! $price->end_at || $price->end_at->endOfDay()->greaterThan(Carbon::now()))
            ->sortByDesc('start_at');
    }

    /** @return Attribute<null | int, never> */
    public function currentPrice(): Attribute
    {
        return Attribute::get(fn () => $this->currentPrices()->first()?->price);
    }

    /** @return Attribute<null | int, never> */
    public function oldPrice(): Attribute
    {
        return Attribute::get(function () {
            if ((bool) $this->currentPrices()->first()?->sale_price === true) {
                return $this->currentPrices()->skip(1)->first()?->price;
            }

            return null;
        });
    }

    /** @return Attribute<array{current_price: int, old_price?: int}, never> */
    public function price(): Attribute
    {
        return Attribute::get(function () {
            $rtr = ['current_price' => $this->currentPrice];

            if ($this->oldPrice !== null && $this->oldPrice !== 0) {
                $rtr['old_price'] = $this->oldPrice;
            }

            return $rtr;
        });
    }

    protected function linkRoot(): string
    {
        return 'shop/product';
    }

    public function toSearchableArray(): array
    {
        return $this->transform([
            'title' => $this->title,
            'description' => $this->description,
            'metaTags' => $this->meta_keywords,
        ]);
    }

    public function shouldBeSearchable(): bool
    {
        return $this->variants->filter(fn ($query) => $query->live)->count() > 0;
    }

    //    protected function richTextType(): string
    //    {
    //        return 'Product';
    //    }
    //
    //    protected function toRichText(): array
    //    {
    //        $core = [
    //            'sku' => $this->id,
    //            'name' => $this->title,
    //            'brand' => [
    //                '@type' => 'Organization',
    //                'name' => 'Coeliac Sanctuary',
    //                'logo' => [
    //                    '@type' => 'ImageObject',
    //                    'url' => 'https://www.coeliacsanctuary.co.uk/assets/svg/logo.svg',
    //                ],
    //            ],
    //            'description' => $this->description,
    //            'image' => [$this->first_image],
    //            'offers' => [
    //                '@type' => 'Offer',
    //                'price' => $this->currentPrice / 100,
    //                'availability' => $this->isInStock() ? 'InStock' : 'OutOfStock',
    //                'priceCurrency' => 'GBP',
    //                'url' => $this->absolute_link,
    //                'shippingDetails' => [
    //                    '@type' => 'OfferShippingDetails',
    //                    'shippingDestination' => [
    //                        '@type' => 'DefinedRegion',
    //                        'addressCountry' => 'UK',
    //                    ],
    //                    'deliveryTime' => [
    //                        '@type' => 'ShippingDeliveryTime',
    //                        'businessDays' => [
    //                            '@type' => 'OpeningHoursSpecification',
    //                            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
    //                        ],
    //                        'cutOffTime' => '12:00',
    //                        'handlingTime' => [
    //                            '@type' => 'QuantitativeValue',
    //                            'minValue' => 0,
    //                            'maxValue' => 1,
    //                        ],
    //                        'transitTime' => [
    //                            '@type' => 'QuantitativeValue',
    //                            'minValue' => 1,
    //                            'maxValue' => 3,
    //                        ],
    //                    ],
    //                    'shippingRate' => [
    //                        '@type' => 'MonetaryAmount',
    //                        'currency' => 'GBP',
    //                        'value' => $this->baseShippingRate() / 100,
    //                    ],
    //                ],
    //            ],
    //        ];
    //
    //        if ($this->reviews()->count() > 0) {
    //            $core = array_merge($core, [
    //                'review' => $this->reviews()
    //                    ->latest()
    //                    ->with(['parent'])
    //                    ->get()
    //                    ->map(fn (ShopOrderReviewItem $review) => [
    //                        '@type' => 'Review',
    //                        'reviewRating' => [
    //                            '@type' => 'Rating',
    //                            'ratingValue' => $review->rating,
    //                            'bestRating' => '5',
    //                        ],
    //                        'author' => [
    //                            '@type' => 'Person',
    //                            'name' => $review->parent->name,
    //                        ],
    //                    ]),
    //                'aggregateRating' => [
    //                    '@type' => 'AggregateRating',
    //                    'ratingValue' => $this->reviews()->average('rating'),
    //                    'reviewCount' => $this->reviews()->count(),
    //                ],
    //            ]);
    //        }
    //
    //        return $core;
    //    }
}
