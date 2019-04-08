<?php

namespace App\Models\SpatiePermission;

use App\Traits\WebGuardScope;
use Tightenco\Parental\HasParentModel;
use App\Traits\SpatiePermission;

class WebRole extends Role
{
    use HasParentModel;
    use SpatiePermission;
    use WebGuardScope;

    protected $table = 'roles';
    protected static $guard_name = 'web';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'guard_name',
    ];
}
