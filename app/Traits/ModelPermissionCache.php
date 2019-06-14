<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ModelPermissionCache
{
    /**
     * Cache Model permission for 10 minutes
     * Use in JsonResource to cache model permission for performance in listing usage
     * @param $permission_key
     * @return mixed
     */
    public function cacheModelPermissions($permission_key)
    {
        $cache_key = 'user_' . auth()->id() . '_' . $permission_key . '_' . $this->resource->id;

        if (!Cache::has($cache_key)) {
            Cache::put($cache_key, $this->permissions(), now()->addMinutes(10));
        }

        $permissions = Cache::get($cache_key);

        return $permissions;

    }
}