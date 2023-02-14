<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\File\FileUploader;
use App\DTO\FileUploaderDTO;
use App\Exceptions\FileNotRegisteredException;
use App\Exceptions\FilePathException;
use App\Facades\Normalizer;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileUploadRequest;
use App\Traits\Controllers\ApiResponse;
use Illuminate\Http\JsonResponse;
use JsonException;
use Throwable;

final class FileUploadController extends Controller
{
    use ApiResponse;

    public function __invoke(FileUploadRequest $fileUploadRequest, FileUploader $fileUploader): JsonResponse
    {
        try {
            return $this->sendResponse($fileUploader->handle(Normalizer::denormalize($fileUploadRequest->validated(), FileUploaderDTO::class)), 200);
        } catch (FileNotRegisteredException) {
            return $this->sendError('Не удалось сохранить все файлы. Повторите попытку позднее');
        } catch (FilePathException $exception) {
            return $this->sendError($exception->getMessage());
        } catch (JsonException) {
            return $this->sendError('Не удалось преобразовать метаданные в JSON');
        } catch (Throwable) {
            return $this->sendError('Произошла неизвестная ошибка при попытке загрузить файлы. Повторите попытку позднее');
        }
    }
}
