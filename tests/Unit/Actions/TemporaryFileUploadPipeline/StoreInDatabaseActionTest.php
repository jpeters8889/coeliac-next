<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\TemporaryFileUploadPipeline;

use App\Models\TemporaryFileUpload;
use Illuminate\Http\UploadedFile;

class StoreInDatabaseActionTest extends TemporaryFileUploadTestCase
{
    /** @test */
    public function it_stores_the_file(): void
    {
        $this->assertEmpty(TemporaryFileUpload::all());

        $this->callStoreInDatabaseAction(UploadedFile::fake()->create('foo.pdf'));

        $this->assertNotEmpty(TemporaryFileUpload::all());
    }
}
