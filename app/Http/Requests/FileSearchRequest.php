<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class FileSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid' => 'required_without:metadata|uuid|min:1|max:255',
            'service' => 'string|min:1|max:255',
            'category' => 'string|min:1|max:255',
            'metadata' => 'array|required_without:uuid|min:1|max:20',
        ];
    }
}
