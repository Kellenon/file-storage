<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\File\FileFinder;
use App\DTO\FileFinderDTO;
use App\Exceptions\UuidInvalidException;
use App\Facades\Normalizer;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileSearchRequest;
use App\Traits\Controllers\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class FileSearchController extends Controller
{
    use ApiResponse;

    public function __invoke(FileSearchRequest $fileSearchRequest, FileFinder $fileFinder): JsonResponse
    {
        try {
            return $this->sendResponse($fileFinder->handle(Normalizer::denormalize($fileSearchRequest->validated(), FileFinderDTO::class)), 200);
        } catch (ModelNotFoundException) {
            return $this->sendError('Не удалось найти запись исходя из указанного UUID');
        } catch (QueryException) {
            return $this->sendError('Произошла ошибка при составлении запроса. Возможно, что «метаданные» содержат в себе ошибку.');
        } catch (UuidInvalidException $exception) {
            return $this->sendError($exception->getMessage());
        } catch (Throwable) {
            return $this->sendError('Произошла неизвестная ошибка при попытке найти файлы. Повторите попытку позднее');
        }
    }
}
