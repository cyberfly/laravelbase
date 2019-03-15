<?php

use App\Models\SpatiePermission\ApiRole;
use App\Models\SpatiePermission\WebRole;
use Illuminate\Database\Seeder;

abstract class AbstractRoleSeeder extends Seeder
{
    /**
     * Create new roles
     * To use, extend this class with method getRolesData()
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create roles

        $roles_data = $this->getRolesData();

        if (!empty($roles_data)) {

            foreach ($roles_data as $role_data) {

                $role_data = collect($role_data);
                $role_name = $role_data['name'];

                $role_guards = $role_data['guards'];

                if (!empty($role_guards)) {
                    foreach ($role_guards as $role_guard) {

                        $this->createRole($role_data, $role_name, $role_guard);

                    }
                }

            }
        }
    }

    protected function createRole($role_data, $role_name, $role_guard)
    {
        if ($role_guard === 'api') {

            $role = ApiRole::firstByName($role_name);

            if (!$role) {
                $role = ApiRole::create($role_data->except('guards')->all());
            }
        }
        else if ($role_guard === 'web') {

            $role = WebRole::firstByName($role_name);

            if (!$role) {
                $role = WebRole::create($role_data->except('guards')->all());
            }
        }
    }
}
