<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class FileUploadRequest extends FileRegisterRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'files' => 'required',
            'files.*' => 'file|max:102400|mimes:jpg,png,pdf,doc,docx,gif,xls,xlsx,txt,ppt,pptx,xml,csv,heic,jpeg,json',
        ]);
    }
}
