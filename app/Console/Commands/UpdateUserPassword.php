<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UpdateUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'base:update-user-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update specific user password for development purpose';

    /**
     * Create a new command instance.
     *
     * @return void
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
            $new_password = $this->ask('New password? (default 123)', 123);

            $data = [
                'password' => Hash::make($new_password),
            ];

            $user->update($data);

            $this->info("$user->email password updated! Password: $new_password");
        }
        else {
            $this->error('User not exist');
        }
    }
}
