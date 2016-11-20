<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserSetPassword extends Command
{

    protected $signature = 'user:set-password {user : The user whose password you are changing}';

    protected $description = 'Sets a users password';

    public function handle()
    {

        $userName = $this->argument('user');

        try {
            $user = User::whereUsername($userName)->firstOrFail();

            $this->info('Changing password for ' . $userName);

            $pass1 = $this->secret('Enter a new password');
            $pass2 = $this->secret('Repeat the password');

            if ($pass1 !== $pass2) {
                $this->error('Passwords do not match.');
                return;
            }

            $user->password = bcrypt($pass1);

            $this->info('Password set');

        } catch (ModelNotFoundException $e) {
            $this->error("User {$userName} not found.");
            return;
        }
    }
}
