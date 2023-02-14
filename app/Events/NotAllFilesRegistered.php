<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class NotAllFilesRegistered
{
    public array $alreadyUploadedFiles;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param string[] $alreadyUploadedFiles
     */
    public function __construct(array $alreadyUploadedFiles = [])
    {
        $this->alreadyUploadedFiles = $alreadyUploadedFiles;
    }
}
