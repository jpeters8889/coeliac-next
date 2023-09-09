<?php

declare(strict_types=1);

namespace App\Jobs\EatingOut;

use App\Models\EatingOut\EateryReview;
use App\Models\TemporaryFileUpload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProcessReviewImagesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected EateryReview $review, protected array $fileIds)
    {
        //
    }

    public function handle(): void
    {
        TemporaryFileUpload::query()
            ->findMany($this->fileIds)
            ->each(function (TemporaryFileUpload $file): void {
                $rawFile = Storage::disk('uploads')->get($file->path);

                $this->persistImage($file, $rawFile);
                $this->generateThumbnail($rawFile, $file);
                $this->storeImageRow($file);
            });
    }

    protected function persistImage(TemporaryFileUpload $file, ?string $rawFile): void
    {
        Storage::disk('review-images')->put($file->filename, (string) $rawFile, 'public');
    }

    protected function generateThumbnail(?string $rawFile, TemporaryFileUpload $file): void
    {
        $thumbnail = Image::make($rawFile)
            ->resize(250, 250, fn ($constraint) => $constraint->aspectRatio())
            ->encode(quality: 80);

        Storage::disk('review-images')->put('thumbs/' . $file->filename, (string) $thumbnail, 'public');
    }

    protected function storeImageRow(TemporaryFileUpload $file): void
    {
        $this->review->images()->create([
            'wheretoeat_id' => $this->review->wheretoeat_id,
            'thumb' => 'thumbs/' . $file->filename,
            'path' => $file->path,
        ]);
    }
}
