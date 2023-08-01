<?php

declare(strict_types=1);

namespace App\Resources\Blogs;

use App\Models\Blogs\Blog;
use App\Resources\Collections\FeaturedInCollectionSimpleCardViewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/** @mixin Blog */
class BlogShowResource extends JsonResource
{
    /** @return array{id: number, title: string, image: string, published: string, updated: string, description: string, body: string, tags: BlogTagCollection} */
    public function toArray(Request $request)
    {
        $this->load(['associatedCollections', 'associatedCollections.collection', 'associatedCollections.collection.media']);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->main_image,
            'published' => $this->published,
            'updated' => $this->lastUpdated,
            'description' => $this->description,
            'body' => Str::markdown($this->body, [
                'renderer' => [
                    'soft_break' => "<br />",
                ],
            ]),
            'tags' => new BlogTagCollection($this->tags),
            'featured_in' => FeaturedInCollectionSimpleCardViewResource::collection($this->associatedCollections)
        ];
    }
}
