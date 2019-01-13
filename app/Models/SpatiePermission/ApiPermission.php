<?php

namespace App\Models\SpatiePermission;

use App\Traits\ApiGuardScope;
use App\Traits\SpatiePermission;
use Spatie\Permission\Models\Permission as SpatiePermissionModel;
use Tightenco\Parental\HasParentModel;

class ApiPermission extends SpatiePermissionModel
{
    use HasParentModel;
    use SpatiePermission;
    use ApiGuardScope;

    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected static $guard_name = 'api';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'guard_name',
    ];
}