<?php

namespace App\Models\SpatiePermission;

use App\Traits\Filterable;
use Spatie\Permission\Models\Role as SpatieRoleModel;

class Role extends SpatieRoleModel
{
    use Filterable;
}
