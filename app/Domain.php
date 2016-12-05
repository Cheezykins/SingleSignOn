<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'domain_roles')->withTimestamps();
    }
}
