<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\Shared\UploadTemporaryFile\Steps;

use PHPUnit\Framework\Attributes\Test;
use App\Models\TemporaryFileUpload;
use Illuminate\Http\UploadedFile;

class StoreInDatabaseActionTest extends TemporaryFileUploadTestCase
{
    #[Test]
    public function it_stores_the_file(): void
    {
        $this->assertEmpty(TemporaryFileUpload::all());

        $this->callStoreInDatabaseAction(UploadedFile::fake()->create('foo.pdf'));

        $this->assertNotEmpty(TemporaryFileUpload::all());
    }
}
