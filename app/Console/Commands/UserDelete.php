<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserDelete extends Command
{

    protected $signature = 'user:delete {user : The user to delete}';

    protected $description = 'Delete a user';

    public function handle()
    {
        $userName = $this->argument('user');

        try {
            $user = User::whereUsername($userName)->firstOrFail();

            if ($this->confirm('Are you sure you wish to delete user ' . $userName . '?')) {
                $user->delete();
                $this->info('User has been deleted');
            }
        } catch (ModelNotFoundException $e) {
            $this->error("User {$userName} not found.");
            return;
        }
    }
}
