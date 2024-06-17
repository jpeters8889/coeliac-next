<?php

declare(strict_types=1);

namespace Tests\Unit\Support\Ai\Prompts;

use App\Support\Ai\Prompts\SearchPrompt;
use Tests\TestCase;

class SearchPromptTest extends TestCase
{
    /** @test */
    public function itIncludesTheSearchTermInThePrompt(): void
    {
        $this->assertStringContainsString('foobar', SearchPrompt::get('foobar'));
    }
}
