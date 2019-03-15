<?php

use App\Models\SpatiePermission\ApiPermission;
use App\Models\SpatiePermission\ApiRole;
use App\Models\SpatiePermission\WebPermission;
use App\Models\SpatiePermission\WebRole;
use Illuminate\Database\Seeder;

abstract class AbstractRolePermissionSeeder extends Seeder
{
    /**
     * Assign permissions to roles
     * To use, extend this class with method getRolePermissionsData()
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_permissions_data = $this->getRolePermissionsData();

        if (!empty($role_permissions_data)) {
            foreach ($role_permissions_data as $role_permission_data) {

                $permission_name   = $role_permission_data['permission_name'];
                $permission_guards = array_get($role_permission_data, 'guards', []);
                $roles             = array_get($role_permission_data, 'roles', []);

                if (!empty($permission_guards)) {
                    foreach ($permission_guards as $permission_guard) {

                        if ($permission_guard === 'api') {
                            $permission = ApiPermission::firstByName($permission_name);
                        } else {
                            if ($permission_guard === 'web') {
                                $permission = WebPermission::firstByName($permission_name);
                            }
                        }

                        if ($permission) {

                            //assign permission to role

                            if (!empty($roles)) {
                                foreach ($roles as $role_name) {

                                    if ($permission_guard === 'api') {
                                        $role = ApiRole::firstByName($role_name);
                                    } else {
                                        if ($permission_guard === 'web') {
                                            $role = WebRole::firstByName($role_name);
                                        }
                                    }

                                    if ($role) {

                                        //assign permission to role

                                        $role_has_permission = $role->hasPermissionTo($permission);

                                        if (!$role_has_permission) {
                                            $role->givePermissionTo($permission);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
