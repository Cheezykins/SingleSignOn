<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserList extends Command
{

    protected $signature = 'user:list';

    protected $description = 'Lists users in the system';

    public function handle()
    {
        $headers = ['Username', 'Roles'];
        $users = [];
        foreach (User::all() as $user) {
            $row = [$user->username];
            $roles = '';
            foreach ($user->roles as $role)
            {
                $roles .= $role->code . PHP_EOL;
            }
            $row[] = rtrim($roles);
            $users[] = $row;
        }

        $this->table($headers, $users);

    }
}
