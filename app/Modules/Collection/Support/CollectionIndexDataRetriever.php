<?php

declare(strict_types=1);

namespace App\Modules\Collection\Support;

use App\Modules\Collection\Models\Collection;
use App\Modules\Collection\Resources\CollectionListCollection;
use Closure;

class CollectionIndexDataRetriever
{
    /** @return array{collections: Closure} */
    public function getData(): array
    {
        return [
            'collections' => fn () => $this->getCollections(),
        ];
    }

    protected function getCollections(): CollectionListCollection
    {
        return new CollectionListCollection(
            Collection::query()
                ->with(['media'])
                ->withCount('items')
                ->latest('updated_at')
                ->paginate(12)
        );
    }
}
