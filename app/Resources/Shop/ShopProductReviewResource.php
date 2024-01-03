<?php

declare(strict_types=1);

namespace App\Resources\Shop;

use App\Models\Shop\ShopOrderReviewItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ShopOrderReviewItem */
class ShopProductReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->parent?->name,
            'review' => $this->review,
            'rating' => $this->rating,
            'date' => $this->created_at,
            'date_diff' => $this->created_at?->diffForHumans(),
        ];
    }
}
