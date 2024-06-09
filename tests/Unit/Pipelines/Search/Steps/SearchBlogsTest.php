<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\Search\Steps;

use App\DataObjects\Search\SearchParameters;
use App\DataObjects\Search\SearchPipelineData;
use App\DataObjects\Search\SearchResultsCollection;
use App\Models\Blogs\Blog;
use App\Pipelines\Search\Steps\SearchBlogs;
use Tests\TestCase;

class SearchBlogsTest extends TestCase
{
    /** @test */
    public function itDoesntSearchAnyBlogsIfTheBlogSearchParameterIsFalse(): void
    {
        $this->create(Blog::class, ['title' => 'Foo']);

        $searchParams = new SearchParameters(
            term: 'foo',
            blogs: false,
        );

        $pipelineData = new SearchPipelineData(
            $searchParams,
            new SearchResultsCollection(),
        );

        $closure = function (SearchPipelineData $data): void {
            $this->assertEmpty($data->results->blogs);
        };

        app(SearchBlogs::class)->handle($pipelineData, $closure);
    }

    /** @test */
    public function itSearchesBlogs(): void
    {
        /** @var Blog $blog */
        $blog = $this->create(Blog::class, ['title' => 'Foo']);

        $searchParams = new SearchParameters(
            term: 'foo',
            blogs: true,
        );

        $pipelineData = new SearchPipelineData(
            $searchParams,
            new SearchResultsCollection(),
        );

        $closure = function (SearchPipelineData $data) use ($blog): void {
            $this->assertNotEmpty($data->results->blogs);
            $this->assertEquals($blog->id, $data->results->blogs->first()->id);
        };

        app(SearchBlogs::class)->handle($pipelineData, $closure);
    }
}
