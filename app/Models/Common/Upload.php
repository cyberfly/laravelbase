<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Upload extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $table = 'uploads';
}
