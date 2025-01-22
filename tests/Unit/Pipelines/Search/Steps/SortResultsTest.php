<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\Search\Steps;

use PHPUnit\Framework\Attributes\Test;
use App\DataObjects\Search\SearchResultItem;
use App\Models\Blogs\Blog;
use App\Models\EatingOut\Eatery;
use App\Models\Recipes\Recipe;
use App\Models\Shop\ShopProduct;
use App\Pipelines\Search\Steps\SortResults;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SortResultsTest extends TestCase
{
    #[Test]
    public function itSortsTheSearchResultsByScoreDesc(): void
    {
        $blog = new SearchResultItem(
            id: 1,
            model: Blog::class,
            score: 123,
            firstWordPosition: 2
        );

        $recipe = new SearchResultItem(
            id: 1,
            model: Recipe::class,
            score: 42,
            firstWordPosition: 2
        );

        $eatery = new SearchResultItem(
            id: 1,
            model: Eatery::class,
            score: 343,
            firstWordPosition: 2
        );

        $product = new SearchResultItem(
            id: 1,
            model: ShopProduct::class,
            score: 241,
            firstWordPosition: 2
        );

        $results = collect([
            $blog,
            $recipe,
            $eatery,
            $product,
        ]);

        $closure = function (Collection $results): void {
            /** @var Collection<int, SearchResultItem> $results */
            $this->assertEquals(Eatery::class, $results->first()->model);
            $this->assertEquals(ShopProduct::class, $results->second()->model);
            $this->assertEquals(Blog::class, $results->third()->model);
            $this->assertEquals(Recipe::class, $results->last()->model);
        };

        app(SortResults::class)->handle($results, $closure);
    }

    #[Test]
    public function itFurtherSortsTheSearchResultsByFirstWordPositionDesc(): void
    {
        $blog = new SearchResultItem(
            id: 1,
            model: Blog::class,
            score: 123,
            firstWordPosition: 2
        );

        $recipe = new SearchResultItem(
            id: 1,
            model: Recipe::class,
            score: 123,
            firstWordPosition: 1
        );

        $results = collect([
            $blog,
            $recipe,
        ]);

        $closure = function (Collection $results): void {
            /** @var Collection<int, SearchResultItem> $results */
            $this->assertEquals(Recipe::class, $results->first()->model);
            $this->assertEquals(Blog::class, $results->last()->model);
        };

        app(SortResults::class)->handle($results, $closure);
    }
}
