<?php

use App\Models\SpatiePermission\ApiRole;
use App\Models\SpatiePermission\WebRole;
use App\User;
use Illuminate\Database\Seeder;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create admin user

        $admin_users = [
            [
                'name' => 'administrator',
                'email' => 'admin@laravelbase.test',
                'password' => bcrypt('admin123'),
            ],
        ];

        if (!empty($admin_users)) {
            foreach ($admin_users as $admin_user) {

                $email = $admin_user['email'];

                $admin = User::whereEmail($email)->first();

                if (!$admin) {

                    // create user

                    $user = User::create($admin_user);

                    if ($user) {

                        // attach administrator role for web and api guard

                        $api_role = ApiRole::firstByName('administrator');

                        if ($api_role) {
                            $user->assignRole($api_role);
                        }

                        $web_role = WebRole::firstByName('administrator');

                        if ($web_role) {
                            $user->assignRole($web_role);
                        }

                    }
                }
            }
        }
    }
}