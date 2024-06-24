<?php

declare(strict_types=1);

namespace App\DataObjects\Search;

use App\Http\Requests\Search\SearchRequest;

class SearchParameters
{
    public function __construct(
        public string $term,
        public bool $blogs = true,
        public bool $recipes = true,
        public bool $eateries = false,
        public bool $shop = true,
        public ?string $locationSearch = null,
        public ?array $userLocation = null,
    ) {
        //
    }

    public static function fromRequest(SearchRequest $request): self
    {
        $userLocation = null;

        if ($request->hasHeader('x-search-location')) {
            /** @var string $location */
            $location = $request->header('x-search-location');

            $userLocation = explode(',', $location);
        }

        return new self(
            $request->string('q')->toString(),
            $request->boolean('blogs'),
            $request->boolean('recipes'),
            $request->boolean('eateries'),
            $request->boolean('shop'),
            userLocation: $userLocation,
        );
    }

    public function toResponse(): array
    {
        return [
            'q' => $this->term,
            'blogs' => $this->blogs,
            'recipes' => $this->recipes,
            'eateries' => $this->eateries,
            'shop' => $this->shop,
        ];
    }

    public function toRequest(): array
    {
        return [
            'q' => $this->term,
            'blogs' => $this->blogs ? 'true' : 'false',
            'recipes' => $this->recipes ? 'true' : 'false',
            'eateries' => $this->eateries ? 'true' : 'false',
            'shop' => $this->shop ? 'true' : 'false',
        ];
    }
}
