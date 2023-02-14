<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\File;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class FilesRegistered
{
    public array $files;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param File[] $files
     */
    public function __construct(array $files)
    {
        $this->files = $files;
    }
}
