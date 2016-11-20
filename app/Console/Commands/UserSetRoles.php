<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserSetRoles extends Command
{
    protected $signature = 'user:set-roles {user : The user to set roles for} {--remove : Remove the roles instead of adding them} {roles* : The roles to add to the user}';

    protected $description = 'Sets a users roles';

    public function handle()
    {
        $userName = $this->argument('user');
        $roles = $this->argument('roles');

        $add = true;
        if ($this->option('remove')) {
            $add = false;
        }

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
                if ($add) {
                    $this->addRole($user, $role);
                } else {
                    $this->subRole($user, $role);
                }

            } catch (ModelNotFoundException $e) {
                $this->error("Role {$roleCode} does not exist");
                continue;
            }
        }
    }

    protected function subRole(User $user, Role $role)
    {
        if (!$user->hasRole($role->code)) {
            $this->info("User already has {$role->code}");
            return;
        }

        $user->roles()->detach($role);
        $this->info("Removed role {$role->code}");
    }

    protected function addRole(User $user, Role $role)
    {
        if ($user->hasRole($role->code)) {
            $this->info("User already has {$role->code}");
            return;
        }

        $user->roles()->attach($role);
        $this->info("Added role {$role->code}");
    }
}
