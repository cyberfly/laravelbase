<?php

namespace App\Models\SpatiePermission;

use App\Traits\ApiGuardScope;
use Tightenco\Parental\HasParentModel;
use App\Traits\SpatiePermission;
use Spatie\Permission\Models\Role as SpatieRoleModel;

class ApiRole extends SpatieRoleModel
{
    use HasParentModel;
    use SpatiePermission;
    use ApiGuardScope;

    protected $table = 'roles';
    protected static $guard_name = 'api';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'guard_name',
    ];
}
