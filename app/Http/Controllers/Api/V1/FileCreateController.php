<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\File\FileCreator;
use App\DTO\FileCreatorDTO;
use App\Exceptions\FileNotCreatedException;
use App\Exceptions\FileNotRegisteredException;
use App\Exceptions\FilePathException;
use App\Facades\Normalizer;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileCreateRequest;
use App\Traits\Controllers\ApiResponse;
use Illuminate\Http\JsonResponse;
use JsonException;
use Throwable;

final class FileCreateController extends Controller
{
    use ApiResponse;

    public function __invoke(FileCreateRequest $fileCreateRequest, FileCreator $fileCreator): JsonResponse
    {
        try {
            return $this->sendResponse($fileCreator->handle(Normalizer::denormalize($fileCreateRequest->validated(), FileCreatorDTO::class)), 201);
        } catch (FileNotCreatedException) {
            return $this->sendError('Не удалось сохранить файл на диске. Повторите попытку позднее');
        } catch (FileNotRegisteredException) {
            return $this->sendError('Не удалось сохранить файл в базе данных. Повторите попытку позднее');
        } catch (FilePathException $exception) {
            return $this->sendError($exception->getMessage());
        } catch (JsonException) {
            return $this->sendError('Не удалось преобразовать метаданные в JSON');
        } catch (Throwable) {
            return $this->sendError('Произошла неизвестная ошибка при попытке создать файлы. Повторите попытку позднее');
        }
    }
}
