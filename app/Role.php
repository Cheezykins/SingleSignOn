<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Role
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserRole[] $user_roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DomainRole[] $domain_roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain[] $domains
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    public function user_roles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, UserRole::class);
    }

    public function domain_roles()
    {
        return $this->hasMany(DomainRole::class);
    }

    public function domains()
    {
        return $this->hasManyThrough(Domain::class, DomainRole::class);
    }

}
