<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class FileCreateRequest extends FileRegisterRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'content' => 'required|string|min:1|max:10485760',
            'extension' => 'required|string|in:txt,json,xml,yaml,html',
        ]);
    }
}
