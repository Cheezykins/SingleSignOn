<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function domains()
    {
        return $this->belongsToMany(Domain::class, 'domain_roles')->withTimestamps();
    }

    /**
     * @param $domainName
     * @return bool
     */
    public function hasDomain($domainName)
    {
        return $this->domains()->whereDomain($domainName)->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function links()
    {
        return $this->belongsToMany(Link::class, 'link_roles')->withTimestamps();
    }

    public function getLinksByCategory()
    {

    }
}
