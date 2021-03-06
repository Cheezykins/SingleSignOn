<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PassGen;
use Hash;

class UserSetPassword extends Command
{

    protected $signature = 'user:reset-password {user? : The user whose password you are changing}';

    protected $description = 'Resets a users password';

    public function handle()
    {

        $userName = $this->argument('user');
        if ($userName === null) {
            $userName = $this->ask("Enter a username");
        }

        try {
            /** @var User $user */
            $user = User::whereUsername($userName)->firstOrFail();

            $this->info('Changing password for ' . $userName);
            $pass = $user->resetPassword();
            $user->save();

            $this->info('New Password: ' . $pass->getPlainText());

        } catch (ModelNotFoundException $e) {
            $this->error("User {$userName} not found.");
            return;
        }
    }
}
