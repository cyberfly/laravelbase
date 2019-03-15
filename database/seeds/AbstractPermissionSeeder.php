<?php

use App\Models\SpatiePermission\ApiPermission;
use App\Models\SpatiePermission\WebPermission;
use Illuminate\Database\Seeder;

class AbstractPermissionSeeder extends Seeder
{
    /**
     * Create new permissions
     * To use, extend this class with method getPermissionsData()
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create permissions

        $permissions = $this->getPermissionsData();

        if (!empty($permissions)) {
            foreach ($permissions as $permission) {

                $permission = collect($permission);

                $permission_name = $permission['name'];
                $permission_guards = $permission['guards'];

                if (!empty($permission_guards)) {
                    foreach ($permission_guards as $permission_guard) {

                        if ($permission_guard=='api') {

                            $api_permission = ApiPermission::firstByName($permission_name);

                            if (!$api_permission) {
                                $api_permission = ApiPermission::create($permission->except('guards')->all());
                            }

                        }
                        else if ($permission_guard=='web') {

                            $web_permission = WebPermission::firstByName($permission_name);

                            if (!$web_permission) {
                                $web_permission = WebPermission::create($permission->except('guards')->all());
                            }
                        }

                    }
                }
            }
        }
    }
}
