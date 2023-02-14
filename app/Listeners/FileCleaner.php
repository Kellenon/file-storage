<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\NotAllFilesRegistered;
use Illuminate\Support\Facades\Storage;

final class FileCleaner
{
    public function handle(NotAllFilesRegistered $event): void
    {
        if (empty($event->alreadyUploadedFiles)) {
            return;
        }

        Storage::delete($event->alreadyUploadedFiles);
    }
}
