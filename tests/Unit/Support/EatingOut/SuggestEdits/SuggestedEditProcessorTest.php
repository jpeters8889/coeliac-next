<?php

declare(strict_types=1);

namespace Tests\Unit\Support\EatingOut\SuggestEdits;

use PHPUnit\Framework\Attributes\Test;
use App\Support\EatingOut\SuggestEdits\Fields\EditableField;
use App\Support\EatingOut\SuggestEdits\SuggestedEditProcessor;
use RuntimeException;
use Tests\TestCase;

class SuggestedEditProcessorTest extends TestCase
{
    #[Test]
    public function itThrowsARuntimeExceptionIfTheEditableFieldDoesntExist(): void
    {
        $this->expectException(RuntimeException::class);

        app(SuggestedEditProcessor::class)->resolveEditableField('foo', 'bar');
    }

    #[Test]
    public function itReturnsAnEditableFieldInstance(): void
    {
        $this->assertInstanceOf(
            EditableField::class,
            app(SuggestedEditProcessor::class)->resolveEditableField('address', 'foo'),
        );
    }
}
