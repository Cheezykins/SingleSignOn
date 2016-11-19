<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Domain
 *
 * @property integer $id
 * @property string $domain
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DomainRole[] $domain_roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Domain whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Domain whereDomain($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Domain whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Domain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Domain extends Model
{
    public function domain_roles()
    {
        return $this->hasMany(DomainRole::class);
    }

    public function roles()
    {
        return $this->hasManyThrough(Role::class, DomainRole::class);
    }
}
