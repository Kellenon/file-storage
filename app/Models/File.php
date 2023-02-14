<?php

namespace App\Models;

use App\Traits\Models\UuidField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $uploader_id
 * @property string $category
 * @property string $service
 * @property string $url
 * @property string $path
 * @property string $metadata
 * @property string $description
 * @property string $disk
 * @property string $created_at
 * @property string $updated_at
 * @property string $available_until
 */
class File extends Model
{
    use HasFactory, UuidField;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uploader_id',
        'category',
        'url',
        'path',
        'metadata',
        'description',
        'available_until',
    ];

    protected $hidden = [
        'path',
        'uploader_id',
        'service',
        'category',
        'disk',
    ];
}
