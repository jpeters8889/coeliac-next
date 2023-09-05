<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\TemporaryFileUploadPipeline;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadFileActionTest extends TemporaryFileUploadTestCase
{
    /** @test */
    public function it_stores_the_file(): void
    {
        $this->assertEmpty(Storage::disk('uploads')->allFiles());

        $this->callUploadFileAction(UploadedFile::fake()->create('foo.pdf'));

        $this->assertNotEmpty(Storage::disk('uploads')->allFiles());
    }
}
