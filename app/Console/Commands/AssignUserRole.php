<?php

namespace App\Console\Commands;

use App\Models\SpatiePermission\WebRole;
use App\User;
use Illuminate\Console\Command;

class AssignUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'base:assign-user-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign specific role to user';

    /**
     * Create a new command instance.
     *
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $default_index = 0;

        $find_by = $this->choice('Find user by?', ['id', 'email'], $default_index);

        $find_value = $this->ask('Find user value?');

        if (empty($find_value)) {
            $this->error('Please enter value!');
            exit;
        }

        $user = User::where($find_by, $find_value)->first();

        if ($user) {

            $roles = WebRole::pluck('name')->all();

            $continue = 'Y';

            while ($continue === 'Y') {

                $role_name = $this->choice('Choose roles to assign', $roles);

                $web_role = WebRole::firstByName($role_name);

                if ($web_role) {
                    $user->assignRole($web_role);
                }

                $this->info("$role_name assigned to $user->email !");

                $continue = $this->choice('Continue?', ['Y', 'N'], 0);

            }
        }
        else {
            $this->error('User not exist');
        }
    }
}
