<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class PublishStatus extends Model
{
    const AUTO_DRAFT = 'AUTO-DRAFT';
    const DRAFT = 'DRAFT';
    const PUBLISH = 'PUBLISH';
}
