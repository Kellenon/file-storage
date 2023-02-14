<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\File\FileRemover;
use App\DTO\FileRemoverDTO;
use App\Facades\Normalizer;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileRemoveRequest;
use App\Traits\Controllers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Throwable;

final class FileRemoveController extends Controller
{
    use ApiResponse;

    public function __invoke(FileRemoveRequest $fileRemoveRequest, FileRemover $fileRemover): JsonResponse
    {
        try {
            if ($fileRemover->handle(Normalizer::denormalize($fileRemoveRequest->validated(), FileRemoverDTO::class))) {
                return $this->sendSuccess('Файл был успешно удален');
            }

            return $this->sendError('Не удалось удалить файл');
        } catch(Throwable) {
            return $this->sendError('Произошла неизвестная ошибка при попытке удалить файл. Повторите попытку позднее');
        }
    }
}
