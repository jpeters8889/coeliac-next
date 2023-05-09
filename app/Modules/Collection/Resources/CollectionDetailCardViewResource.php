<?php

declare(strict_types=1);

namespace App\Modules\Collection\Resources;

use App\Modules\Collection\Models\Collection as CollectionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CollectionModel */
class CollectionDetailCardViewResource extends JsonResource
{
    /** @return array{title: string, link: string, image: string, date: Carbon, description: string} */
    public function toArray(Request $request)
    {
        return [
            'title' => $this->title,
            'link' => $this->link,
            'image' => $this->main_image,
            'date' => $this->created_at,
            'description' => $this->meta_description,
        ];
    }
}
