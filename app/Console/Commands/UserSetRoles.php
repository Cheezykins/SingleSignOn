<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserSetRoles extends Command
{
    protected $signature = 'user:set-roles {user : The user to set roles for} {roles* : The roles to add to the user}';

    protected $description = 'Sets a users roles';

    public function handle()
    {
        $userName = $this->argument('user');
        $roles = $this->argument('roles');

        try {
            /** @var User $user */
            $user = User::whereUsername($userName)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $this->error("User {$userName} cannot be found");
            return;
        }

        foreach ($roles as $roleCode) {
            try {
                $role = Role::whereCode($roleCode)->firstOrFail();

                if ($user->hasRole($role->code)) {
                    $this->info("User already has role {$roleCode}");
                    continue;
                }
                $user->roles()->attach($role);
                $this->info("Added role {$roleCode}");
            } catch (ModelNotFoundException $e) {
                $this->error("Role {$roleCode} does not exist");
                continue;
            }
        }
    }
}
