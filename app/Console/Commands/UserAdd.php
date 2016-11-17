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
        $password = $this->secret("Enter a password");

        $user = new User();
        $user->username = $username;
        $user->password = bcrypt($password);
        $user->save();

        $this->info('User ' . $username . ' created successfully');
    }
}
