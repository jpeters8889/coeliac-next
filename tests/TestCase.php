<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\CreatesFactories;
use Tests\Concerns\InteractsWithActions;
use Tests\Concerns\InteractsWithPipelines;
use Tests\Concerns\SeedsWebsite;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use CreatesFactories;
    use InteractsWithActions;
    use InteractsWithPipelines;
    use RefreshDatabase;
    use SeedsWebsite;

    protected function migrateUsing(): array
    {
        return [
            '--schema-path' => 'database/schema/mysql-schema.dump',
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        DB::connection()->getSchemaBuilder()->disableForeignKeyConstraints();
    }

    protected function assertSortedAlphabetically(array $items): void
    {
        $lookup = range('a', 'z');

        foreach ($items as $index => $item) {
            if ($index === 0) {
                continue;
            }

            $item = str_replace(' ', '', $item);
            $toCompare = str_replace(' ', '', $items[$index - 1]);

            $characterIndex = 0;
            $currentLetter = 0;
            $previousLetter = 0;

            while ($currentLetter === $previousLetter) {
                $currentLetter = mb_strlen($item) > $characterIndex ? array_search($item[$characterIndex], $lookup) : 30;
                $previousLetter = mb_strlen($toCompare) > $characterIndex ? array_search($toCompare[$characterIndex], $lookup) : -1;

                $characterIndex++;
            }

            $this->assertGreaterThan(
                $previousLetter,
                $currentLetter,
                "Failed to assert that {$item} comes after {$toCompare} alphabetically"
            );
        }
    }
}
