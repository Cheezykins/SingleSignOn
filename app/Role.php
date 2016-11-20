<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Role
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain[] $domains
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles')->withTimestamps();
    }

    public function domains()
    {
        return $this->belongsToMany(Domain::class, 'domain_roles')->withTimestamps();
    }

    public function hasDomain($domainName)
    {
        return $this->domains()->whereDomain($domainName)->count() > 0;
    }
}
