<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


/**
 * App\User
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property boolean $must_change_pass
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $readNotifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereMustChangePass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return ['exp' => time() + 157784760];
    }

    /**
     * Verifies if a user has a role.
     * @param $roleName
     * @return bool
     */
    public function hasRole($roleName)
    {
        return $this->roles()->whereCode($roleName)->count() > 0;
    }

    /**
     * Verifies if a user can access a domain name
     * @param $domainName
     * @return bool
     */
    public function canAccess($domainName)
    {
        foreach ($this->roles as $role)
        {
            if ($role->hasDomain($domainName))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Get an array of links grouped by category name.
     * @return array
     */
    public function linksByCategory()
    {
        $links = [];
        foreach ($this->roles as $role)
        {
            foreach ($role->links as $link)
            {
                if (!array_key_exists($link->category->name, $links))
                {
                    $links[$link->category->name] = [];
                }
                $links[$link->category->name][] = $link;
            }
        }
        return $links;
    }
}
