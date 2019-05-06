<?php

namespace App;

use App\Models\SpatiePermission\WebPermission;
use App\Traits\Filterable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravie\Authen\AuthenUser;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use Filterable;
    use AuthenUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return array
     */
    public function getAuthIdentifiersName()
    {
        return ['email', 'name'];
    }

    /**
     * Get list of web permissions to use in Vue component / front end
     * @return array
     */
    public function getWebPermissionsAttribute()
    {
        $permissions = [];

        foreach (WebPermission::all() as $permission) {
            if (auth()->user()->can($permission->name)) {
                $permissions[] = $permission->name;
            }
        }

        return $permissions;
    }
}
