<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\DomainRole
 *
 * @property integer $id
 * @property integer $domain_id
 * @property integer $role_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Domain $domain
 * @property-read \App\Role $role
 * @method static \Illuminate\Database\Query\Builder|\App\DomainRole whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DomainRole whereDomainId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DomainRole whereRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DomainRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DomainRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DomainRole extends Model
{
    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
