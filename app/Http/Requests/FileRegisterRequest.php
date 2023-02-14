<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => 'required|string|min:1|max:255',
            'service' => 'required|string|min:1|max:255',
            'description' => 'string|min:2|max:5000',
            'specialPath' => 'string|min:1|max:255',
            'availableUntil' => 'date',
            'metadata' => 'array|max:20',
        ];
    }
}
