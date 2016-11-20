<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class UserAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a new user';

    public function handle()
    {
        $username = $this->ask("Enter a username");
        $pass1 = $this->secret("Enter a password");
        $pass2 = $this->secret("Repeat the password");

        if ($pass1 !== $pass2) {
            $this->error('Passwords do not match');
            return;
        }

        $user = new User();
        $user->username = $username;
        $user->password = bcrypt($pass1);
        $user->save();

        $this->info('User ' . $username . ' created successfully');
    }
}
