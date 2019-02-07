<?php

namespace App\Models\Example;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Gallery extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;

    protected $table = 'example_galleries';

    protected $fillable = [
        'title',
        'description',
    ];
}
