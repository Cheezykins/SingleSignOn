<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;
use PassGen;

class UserAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add {user? : The username to add}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a new user';

    public function handle()
    {
        $username = $this->argument('user');
        if ($username === null) {
            $username = $this->ask("Enter a username");
        }

        $password = PassGen::generate(4);

        $user = new User();
        $user->username = $username;
        $user->password = bcrypt($password->getPlainText());
        $user->save();

        $this->info('User ' . $username . ' created successfully');
        $this->info('Password: ' . $password->getPlainText());

        $roles = Role::whereUserDefault(true)->get();
        if ($roles->count() > 0) {
            $this->info('Adding default roles:');
            foreach ($roles as $role)
            {
                $this->info($role->code);
                $user->roles()->attach($role);
            }
            $this->info('Done');
        }
    }
}
