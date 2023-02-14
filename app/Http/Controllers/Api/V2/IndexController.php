<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Traits\Controllers\ApiResponse;
use Illuminate\Http\JsonResponse;

final class IndexController extends Controller
{
    use ApiResponse;

    public function __invoke(): JsonResponse
    {
        return $this->sendSuccess('File Storage | api v2');
    }
}
